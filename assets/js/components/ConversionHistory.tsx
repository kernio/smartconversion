import React from 'react'
import { DataTable } from '@shopify/polaris'
import { useSelector } from 'react-redux'
import { RootState } from '../reducers'

export const ConversionHistory: React.FC = () => {
    const rows = useSelector((state: RootState) => state.conversionHistory.rows)

    return (
        <DataTable
            columnContentTypes={[
                'text',
                'numeric',
                'text',
                'numeric'
            ]}
            headings={[
                'Source Currency',
                'Source Amount',
                'Output Currency',
                'Output Amount'
            ]}
            rows={rows}
        />
    )
}
