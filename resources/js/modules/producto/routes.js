import ProductoList from './components/ProductoList'
import ProductoView from './components/ProductoView'

export const routes = [
    {
        path: '/productos',
        name: 'Productos',
        component: ProductoList,
    },
    {
        path: '/productos/:id',
        name: 'Show Producto',
        component: ProductoView,
        hidden: true
    },
]
