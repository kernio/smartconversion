import * as React from 'react'
import * as ReactDOM from 'react-dom'
import { AppProvider, Card, Layout, Page } from '@shopify/polaris'
import enTranslations from '@shopify/polaris/locales/en.json'
import { Provider as ReduxProvider } from 'react-redux'
import store from './store/index'
import { ConversionForm } from './components/ConversionForm'
import { ConversionHistory } from './components/ConversionHistory'

import '@shopify/polaris/styles.css'

ReactDOM.render(
    <div>
        <ReduxProvider store={store}>
            <AppProvider i18n={enTranslations}>
                <Page>
                    <Layout>
                        <Layout.Section>
                            <Card title="Currency Conversion" sectioned>
                                <ConversionForm/>
                            </Card>
                            <Card title="Conversion History" sectioned>
                                <ConversionHistory/>
                            </Card>
                        </Layout.Section>
                    </Layout>
                </Page>
            </AppProvider>
        </ReduxProvider>
    </div>,
    document.querySelector('#app')
)
