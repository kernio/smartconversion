import { ConversionHistory, ConversionHistoryActionTypes, PUSH_CONVERTED_HISTORY } from '../types/conversionHistory'

const MAX_HISTORY_SIZE = 10

const initialState: ConversionHistory = {
    rows: []
}

export default function (
    state: ConversionHistory = initialState, action: ConversionHistoryActionTypes): ConversionHistory {
    if (action.type === PUSH_CONVERTED_HISTORY) {
        const historyElement = [
            action.sourcePrice.currency,
            action.sourcePrice.amount,
            action.outputPrice.currency,
            action.outputPrice.amount
        ]
        const items = [...[historyElement], ...state.rows]

        while (items.length > MAX_HISTORY_SIZE) { items.pop() }

        return {
            ...state,
            rows: items
        }
    } else { return state }
}
