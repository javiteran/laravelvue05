<template>
    <section id="producto_show">
        <div class="text-center">
            {{ producto.name }}
        </div>
    </section>
</template>

<script>
import productoApi from '../api'

export default {
    name: 'ProductoView',
    components: {},
    data() {
        return {
            producto: {},
        }
    },
    methods: {
        async fetchProducto() {
            const response = await productoApi.find(this.$route.params.id)
            this.producto = response.data.data
        },
    },
    mounted() {
        this.fetchProducto()
    },
}
</script>
