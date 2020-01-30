import {
    ConversionActionTypes,
    ConversionState,
    RECEIVE_CONVERTED_PRICE, REQUEST_CONVERTED_PRICE
} from '../types/conversion'

const initialState: ConversionState = {
    isLoading: false,
    convertedPrice: null
}

export default function (state: ConversionState = initialState, action: ConversionActionTypes): ConversionState {
    switch (action.type) {
        case REQUEST_CONVERTED_PRICE:
            return {
                ...state,
                isLoading: true
            }
        case RECEIVE_CONVERTED_PRICE:
            return {
                ...state,
                isLoading: false,
                convertedPrice: action.price
            }
        default:
            return state
    }
}
