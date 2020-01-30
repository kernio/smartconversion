import { ConversionHistory, ConversionHistoryActionTypes, PUSH_CONVERTED_HISTORY } from '../types/conversionHistory'

const MAX_HISTORY_SIZE = 10

const initialState: ConversionHistory = {
    rows: []
}

export default function (
    state: ConversionHistory = initialState, action: ConversionHistoryActionTypes): ConversionHistory {
    if (action.type === PUSH_CONVERTED_HISTORY) {
        const rows = state.rows
        rows.unshift([
            action.sourcePrice.currency,
            action.sourcePrice.amount,
            action.outputPrice.currency,
            action.outputPrice.amount
        ])
        console.debug(rows)
        while (rows.length > MAX_HISTORY_SIZE) { rows.pop() }
        return {
            ...state,
            rows: rows
        }
    } else { return state }
}
