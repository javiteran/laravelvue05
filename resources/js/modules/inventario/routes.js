import InventarioList from './components/InventarioList'
import InventarioView from './components/InventarioView'

export const routes = [
    {
        path: '/inventarios',
        name: 'Inventarios',
        component: InventarioList,
    },
    {
        path: '/inventarios/:id',
        name: 'Show Inventario',
        component: InventarioView,
        hidden: true
    },
]
