import axios, { AxiosResponse } from 'axios'
import Router from '../router'
import { Dispatch } from 'redux'
import {
    ConvertPriceRequest,
    ConvertPriceResponse,
    Price,
    RECEIVE_CONVERTED_PRICE,
    ReceiveConvertedPriceAction,
    REQUEST_CONVERTED_PRICE,
    RequestConvertedPriceAction
} from '../types/conversion'
import { pushPriceToConvertedHistory } from './conversionHistory'

export const convertCurrency = (convertPriceRequest: ConvertPriceRequest) => (dispatch: Dispatch) => {
    dispatch(startRequestConvertCurrency())

    axios.get(Router.generate('currency_conversion_convert', {
        sourceCurrency: convertPriceRequest.sourcePrice.currency,
        sourceAmount: convertPriceRequest.sourcePrice.amount,
        outputCurrency: convertPriceRequest.outputCurrency
    }))
        .then(function (response: AxiosResponse<ConvertPriceResponse>) {
            dispatch(receiveConvertedPrice(response.data))
            dispatch(pushPriceToConvertedHistory(convertPriceRequest.sourcePrice, response.data))
        })
        .catch((error) => {
            console.log(error)
        })
}

export function startRequestConvertCurrency (): RequestConvertedPriceAction {
    return {
        type: REQUEST_CONVERTED_PRICE
    }
}

export function receiveConvertedPrice (price: Price): ReceiveConvertedPriceAction {
    return {
        type: RECEIVE_CONVERTED_PRICE,
        price: price
    }
}
