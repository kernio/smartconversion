import { combineReducers } from 'redux'

import conversionHistory from './conversionHistory'
import conversion from './conversion'

export const rootReducer = combineReducers({
    conversion: conversion,
    conversionHistory: conversionHistory
})

export type RootState = ReturnType<typeof rootReducer>
