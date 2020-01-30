import React from 'react'
import { Price } from './conversion'

export const PUSH_CONVERTED_HISTORY = 'PUSH_CONVERTED_HISTORY'

declare type TableData = string | number | React.ReactNode;

export interface ConversionHistory {
    rows: TableData[][]
}

export interface PushToConversionHistoryAction {
    type: typeof PUSH_CONVERTED_HISTORY
    sourcePrice: Price
    outputPrice: Price
}

export type ConversionHistoryActionTypes = PushToConversionHistoryAction
