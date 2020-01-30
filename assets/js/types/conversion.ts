export const REQUEST_CONVERTED_PRICE = 'REQUEST_CONVERTED_PRICE'
export const RECEIVE_CONVERTED_PRICE = 'RECEIVE_CONVERTED_PRICE'

export interface Price {
    amount: number
    currency: string
}

export interface ConvertPriceRequest {
    sourcePrice: Price
    outputCurrency: string
}

export interface ConvertPriceResponse extends Price {
}

export interface RequestConvertedPriceAction {
    type: typeof REQUEST_CONVERTED_PRICE
}

export interface ReceiveConvertedPriceAction {
    type: typeof RECEIVE_CONVERTED_PRICE
    price: Price
}

export interface ConversionState {
    isLoading: boolean,
    convertedPrice: Price
}

export type ConversionActionTypes = ReceiveConvertedPriceAction | RequestConvertedPriceAction
