<template>
    <section id="inventario_show">
        <div class="text-center">
           Nombre: {{ inventario.name }}
        </div>
        <div class="text-center">
           Marca:  {{ inventario.marca }}
        </div>  
        <div class="text-center">
           Departamento: {{ inventario.Departamento }}
        </div>        <div class="text-center">
           Tipo de Hardware: {{ inventario.TipoHardware }}
        </div>
            <div class="card" style="width: 18rem;">                
                <div class="card-body">
                    <h5 class="card-title">Nombre</h5>
                    <p class="card-text">{{ inventario.name }}.</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ inventario.marca }}</li>
                    <li class="list-group-item">{{ inventario.Departamento }}</li>  
                    <li class="list-group-item">{{ inventario.TipoHardware }}</li>


                </ul>
            </div>

    </section>
</template>

<script>
import inventarioApi from '../api'

export default {
    name: 'InventarioView',
    components: {},
    data() {
        return {
            inventario: {},
        }
    },
    methods: {
        async fetchInventario() {
            const response = await inventarioApi.find(this.$route.params.id)
            this.inventario = response.data.data
        },
    },
    mounted() {
        this.fetchInventario()
    },
}
</script>
