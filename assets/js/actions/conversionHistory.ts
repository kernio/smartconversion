import { Price } from '../types/conversion'
import { ConversionHistoryActionTypes, PUSH_CONVERTED_HISTORY } from '../types/conversionHistory'

export function pushPriceToConvertedHistory (sourcePrice: Price, outputPrice: Price): ConversionHistoryActionTypes {
    return {
        type: PUSH_CONVERTED_HISTORY,
        sourcePrice: sourcePrice,
        outputPrice: outputPrice
    }
}
