import React, { useCallback, useState } from 'react'
import { Button, FormLayout, Heading, TextContainer, TextField } from '@shopify/polaris'
import { CurrencySelect } from './CurrencySelect'
import { convertCurrency } from '../actions/conversion'
import { useDispatch, useSelector } from 'react-redux'
import { Price } from '../types/conversion'
import { RootState } from '../reducers'

export const ConversionForm: React.FC = () => {
    const dispatch = useDispatch()

    const [amount, setAmount] = useState('')
    const [amountError, setAmountError] = useState('')

    const [sourceCurrency, setSourceCurrency] = useState('USD')
    const [outputCurrency, setOutputCurrency] = useState('EUR')

    const handleAmountChange = useCallback((newAmount) => setAmount(newAmount), [])
    const handleSourceCurrencyChange = useCallback((newValue) => setSourceCurrency(newValue), [])
    const handleOutputCurrencyChange = useCallback((newValue) => setOutputCurrency(newValue), [])

    const isLoading = useSelector((state: RootState) => state.conversion.isLoading)
    const convertedPrice: Price = useSelector((state: RootState) => state.conversion.convertedPrice)

    const submitForm = () => {
        setAmountError('')

        const amountNumber = Number(amount)

        if (isNaN(amountNumber) || amountNumber <= 0) {
            setAmountError('Amount should be more that 0')
            return
        }

        const sourcePrice: Price = {
            amount: amountNumber,
            currency: sourceCurrency
        }
        dispatch(convertCurrency({
            sourcePrice,
            outputCurrency
        }))
    }

    return (
        <FormLayout>
            <FormLayout.Group>
                <CurrencySelect value={sourceCurrency} label="Source Currency" onChange={handleSourceCurrencyChange}/>
                <TextField label="Amount" type="number" value={amount} onChange={handleAmountChange} error={amountError}/>
                <CurrencySelect value={outputCurrency} label="Output Currency" onChange={handleOutputCurrencyChange}/>
                <Button onClick={submitForm} loading={isLoading}>Convert</Button>
            </FormLayout.Group>
            {convertedPrice && !isLoading ? <TextContainer>
                <Heading>Conversion Result: {convertedPrice.amount} {convertedPrice.currency}</Heading>
            </TextContainer> : ''}
        </FormLayout>
    )
}
