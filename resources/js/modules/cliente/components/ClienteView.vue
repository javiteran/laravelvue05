<template>
    <section id="cliente_show">
        <div class="text-center">
            {{ cliente.name }}
        </div>
    </section>
</template>

<script>
import clienteApi from '../api'

export default {
    name: 'ClienteView',
    components: {},
    data() {
        return {
            cliente: {},
        }
    },
    methods: {
        async fetchCliente() {
            const response = await clienteApi.find(this.$route.params.id)
            this.cliente = response.data.data
        },
    },
    mounted() {
        this.fetchCliente()
    },
}
</script>
