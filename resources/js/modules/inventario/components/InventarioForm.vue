<template>
    <section id="inventario-form">
        <el-form
            ref="form"
            :model="form"
            label-width="120px"
            :rules="rules"
            size="small"
            @submit.native.prevent="saveSubmit"
        >
            <el-form-item
                label="Nombre"
                prop="name"
                :error="errors.get('name')"
            >
                <el-input
                    v-model="form.name"
                    suffix-icon="el-icon-edit"
                    @change="errors.clear('name')"
                />
            </el-form-item>
        </el-form>
       
        <el-form
            ref="form"
            :model="form"
            label-width="120px"
            :rules="rules"
            size="small"
            @submit.native.prevent="saveSubmit"
        >
            <el-form-item
                label="Marca"
                prop="marca"
                :error="errors.get('marca')"
            >
                <el-input
                    v-model="form.marca"
                    suffix-icon="el-icon-edit"
                    @change="errors.clear('marca')"
                />
            </el-form-item>
        </el-form>


        <el-form
            ref="form"
            :model="form"
            label-width="120px"
            :rules="rules"
            size="small"
            @submit.native.prevent="saveSubmit"
        >
            <el-form-item
                label="Departamento"
                prop="Departamento"
                :error="errors.get('Departamento')"
            >
                <el-input
                    v-model="form.Departamento"
                    suffix-icon="el-icon-edit"
                    @change="errors.clear('Departamento')"
                />
            </el-form-item>
        </el-form>

        <el-form
            ref="form"
            :model="form"
            label-width="120px"
            :rules="rules"
            size="small"
            @submit.native.prevent="saveSubmit"
        >
            <el-form-item
                label="Tipo Hardware"
                prop="TipoHardware"
                :error="errors.get('TipoHardware')"
            >
                <el-input
                    v-model="form.TipoHardware"
                    suffix-icon="el-icon-edit"
                    @change="errors.clear('TipoHardware')"
                />
            </el-form-item>
        </el-form>

        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button
                size="small"
                @click.native="cancel"
            >
                {{ $t('global.cancel') }}
            </el-button>
            <el-button
                :loading="formLoading"
                type="success"
                size="small"
                class="float-right"
                @click.native="saveSubmit"
            >
                {{ $t('global.save') }}
            </el-button>
        </div>
    </section>
</template>

<script>
import {Errors} from '@/includes/Errors'
import inventarioApi from '../api'

export default {
    name: 'InventarioForm',
    props: {
        initialForm: {
            type: Object,
            default: {}
        },
    },
    data() {
        return {
            errors: new Errors(),
            formLoading: false,
            formTitle: 'New Inventario',
            form: {},
            rules: {
                name: [
                    { required: true, message: 'inventario name is required' },
                ],
                marca: [
                    { required: true, message: 'la marca es necesaria' },
                ],
                Departamento: [
                    { required: true, message: 'El Departamento es obligatorio' },
                ],
                TipoHardware: [
                    { required: true, message: 'El Tipo de Hardware es obligatorio' },
                ],                
},
        }
    },
    mounted() {
        this.form = Object.assign({}, this.initialForm)
    },
    watch: {
        initialForm(formData) {
            if(_.isEmpty(formData)) this.clearForm()
            this.form = Object.assign({}, formData)
        }
    },
    methods: {
        saveSubmit() {
            this.$refs.form.validate((valid) => {
                if (valid) {
                    this.formLoading = true
                    this.errors.clear()
                    let action = this.form.id ? inventarioApi.update : inventarioApi.create

                    action(this.form).then((response) => {
                        this.$message({
                            message: response.data.message,
                            type: response.data.type
                        })
                        if(response.data.type === 'success')
                            this.$emit('saved')
                    }).catch(error => {
                        if (error.response.data.errors)
                            this.errors.record(error.response.data.errors)
                    }).finally(() => this.formLoading = false)
                }
            })
        },
        cancel() {
            this.clearForm()
            this.$emit('cancel')
        },
        clearForm() {
            this.errors.clear()
            if (this.$refs.form)
                this.$refs.form.resetFields()
        }
    },
}
</script>
