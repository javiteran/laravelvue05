<template>
    <section id="alumno_show">
        <div class="text-center">
            {{ alumno.name }}
        </div>
        <div class="text-center">
            {{ alumno.curso }}
        </div>        
        <div class="text-center">
            {{ alumno.create_at }}
        </div>
    </section>
</template>

<script>
import alumnoApi from '../api'

export default {
    name: 'AlumnoView',
    components: {},
    data() {
        return {
            alumno: {},
        }
    },
    methods: {
        async fetchAlumno() {
            const response = await alumnoApi.find(this.$route.params.id)
            this.alumno = response.data.data
        },
    },
    mounted() {
        this.fetchAlumno()
    },
}
</script>
