import AlumnoList from './components/AlumnoList'
import AlumnoView from './components/AlumnoView'

export const routes = [
    {
        path: '/alumnos',
        name: 'Alumnos',
        component: AlumnoList,
    },
    {
        path: '/alumnos/:id',
        name: 'Show Alumno',
        component: AlumnoView,
        hidden: true
    },
]
