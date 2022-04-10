import ClienteList from './components/ClienteList'
import ClienteView from './components/ClienteView'

export const routes = [
    {
        path: '/clientes',
        name: 'Clientes',
        component: ClienteList,
    },
    {
        path: '/clientes/:id',
        name: 'Show Cliente',
        component: ClienteView,
        hidden: true
    },
]
