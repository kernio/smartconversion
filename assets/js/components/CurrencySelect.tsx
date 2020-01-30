import React, { useCallback, useState } from 'react'
import { Select } from '@shopify/polaris'

interface AmazonRegionSelectParams {
    onChange? (newValue: string): void
    label?: string
    value?: string
}

export const CurrencySelect: React.FC<AmazonRegionSelectParams> = ({ value, label, onChange }) => {
    const [selectedValue, setSelectedValue] = useState(value || 'EUR')

    const handleSelectChange = useCallback((newValue) => {
        setSelectedValue(newValue)
        if (onChange) {
            onChange(newValue)
        }
    }, [])

    React.useEffect(() => { setSelectedValue(value) }, [value])

    const availableCurrencies = [
        {
            label: '€',
            value: 'EUR'
        },
        {
            label: '$',
            value: 'USD'
        },
        {
            label: 'CA$',
            value: 'CAD'
        },
        {
            label: '¥',
            value: 'JPY'
        }
    ]

    return (
        <Select
            label={label}
            options={availableCurrencies}
            value={selectedValue}
            onChange={handleSelectChange}
        />
    )
}
