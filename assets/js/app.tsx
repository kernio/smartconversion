import * as React from 'react'
import * as ReactDOM from 'react-dom'
import { AppProvider, Card, Layout, Page } from '@shopify/polaris'
import enTranslations from '@shopify/polaris/locales/en.json'
import { Provider as ReduxProvider } from 'react-redux'
import '@shopify/polaris/styles.css'

import store from './store/index'

ReactDOM.render(
    <div>
        <ReduxProvider store={store}>
            <AppProvider i18n={enTranslations}>
                <Page>
                    <Card title="Currency Conversion">

                    </Card>
                </Page>
            </AppProvider>
        </ReduxProvider>
    </div>,
    document.querySelector('#app')
)
