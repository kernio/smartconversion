import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js'

const routes = require('./fos_js_routes')

const Router = Routing
Router.setRoutingData(routes)

export default Router
