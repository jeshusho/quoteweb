<template>
    <AppLayout title="Presupuestos">
        <template  #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Clientes
                </h2>
                <div class="flex flex-row space-x-6 items-center">
                    <button @click.prevent="onNew"
                        class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded flex flex-row space-x-2 text-sm items-center">
                        <PlusIcon class="w-6 h-6"></PlusIcon>
                        <span>NUEVO CLIENTE</span>
                    </button>
                </div>
                
            </div>

        </template>

        <div class="container mx-auto max-w-6xl my-10 overflow-x-auto">
            <table v-if="items.data.length>0" class="table table-zebra w-full">
                <!-- head -->
                <thead>
                <tr>
                    <th class="w-1/12 px-2 py-4 text-center">Código</th>
                    <th class="w-8/12 px-2 py-4">Nombre o Razón Social</th>
                    <th class="w-2/12 px-2 py-4">Documento</th>
                    <th class="w-1/12 px-2 py-4 text-center">Acción</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in items.data" :key="index"
                    class="text-sm text-indigo-900"
                >   
                    <td class="px-2 py-4 text-center">
                        {{ item.code }}
                    </td>
                    <td class="px-2 py-4">
                        {{ item.name }}
                    </td>
                    <td class="px-2 py-4">
                        {{ item.document }}
                    </td>
                    <td class="px-2 py-4 flex flex-row justify-start space-x-4">                       
                        <button @click.prevent="onEdit(item)">
                            <PencilIcon class="h-6 w-6 text-blue-700"/>
                        </button>
                        <button @click.prevent="onDelete(item)" :class="{ hidden:!isAdmin }">
                            <TrashIcon class="h-6 w-6 text-red-700"/>
                        </button>
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="text-center pt-5">                               
                        <nav aria-label="Page navigation example">
                            <ul class="inline-flex -space-x-px">
                                <li v-for="(l,index) in items.links" :key="index">
                                    <a v-if="l.label.includes('laquo')" :href="l.url" class="py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Anterior</a>
                                    <a v-else-if="l.label.includes('raquo')" :href="l.url" class="py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Próximo</a>
                                    <a v-else-if="!l.active" :href="l.url" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{l.label}}</a>
                                    <a v-else-if="l.active" :href="l.url" aria-current="page" class="py-2 px-3 text-blue-600 bg-blue-50 border border-gray-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{l.label}}</a>
                                </li>
                            </ul>
                        </nav>
                    </td>
                    
                </tr>
                </tbody>
            </table>
            <div v-else class="bg-red-100 border border-red-400 p-3 rounded-lg text-red-800 mt-5 text-left max-w-xl mx-auto">
                No hay clientes creados aún
            </div>
        </div>
        <jet-modal :show="showmodal" :closeable="true" @close="showmodal = null" maxWidth="2xl">
            <div class="py-6 mb-4 max-w-xl mx-auto">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                    <span v-if="this.select.length===0">Nuevo Cliente</span>
                    <span v-else>Editar cliente: {{ this.select.name }}</span>
                </h2>
                <hr>
                <form @submit.prevent="submit" >
                    <div class="justify-center w-full">
                        <div class="flex flex-row w-full space-x-4">
                            <div class="form-control basis-5/6">
                                <label class="label">
                                    <span class="label-text">Nombre o Razón social</span>
                                </label>
                                <input v-model="form.name" type="text" placeholder="" class="input input-bordered input-sm w-full" required />
                            </div>
                            <div class="form-control basis-1/6">
                                <label class="label">
                                    <span class="label-text">Código</span>
                                </label>
                                <input v-model="form.code" type="text" placeholder="" class="input input-sm input-bordered w-full" required />
                            </div>
                        </div>
                        
                        <div class="flex flex-row w-full space-x-4">
                            
                            <div class="form-control basis-4/6">
                                <label class="label">
                                    <span class="label-text">Documento</span>
                                </label>
                                <div class="input-group">
                                    <select v-model="form.document_type" class="select select-sm select-bordered text-xs bg-gray-100">
                                        <option value=null disabled selected>Tipo</option>
                                        <option value="ruc">RUC</option>
                                        <option value="dni">DNI</option>
                                        <option value="ce">CE</option>
                                        <option value="passport">PASAPORTE</option>
                                        <option value="other">OTRO</option>
                                    </select>
                                    <input v-model="form.document_number" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                                    <button v-if="form.document_type==='ruc'"
                                            @click.prevent="searchRUC"
                                            class="btn btn-sm bg-gray-100 hover:bg-gray-300 text-indigo-600 border-gray-300 hover:border-gray-400 px-3 py-0">
                                                <MagnifyingGlassIcon class="w-5 h-5"></MagnifyingGlassIcon>
                                    </button>
                                </div>
                            </div>
                            <div class="form-control basis-2/6">
                                <label class="label">
                                    <span class="label-text">Teléfono</span>
                                </label>
                                <input v-model="form.phone" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                            </div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Dirección</span>
                            </label>
                            <input v-model="form.address" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                        </div>
                        <div class="flex space-x-4">
                                <div class="form-control basis-1/2">
                                    <label class="label">
                                        <span class="label-text">Atención a:</span>
                                    </label>
                                    <input v-model="form.contact" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                                </div>
                                <div class="form-control basis-1/2 w-full">
                                    <label class="label">
                                        <span class="label-text">E-mail</span>
                                    </label>
                                    <input v-model="form.email" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                                </div>
                        </div>
                        

                        <div class="flex flex-row space-x-2">
                            <div class="basis-2/6">
                                <label class="label">
                                    <span class="label-text">Validez Presupuesto</span>
                                </label>
                                <div class="input-group">
                                    <input  v-model="form.payday" 
                                            type="number"
                                            placeholder=""
                                            class="input input-sm input-bordered w-full"  />
                                    <span>días</span>
                                </div>
                            </div>
                            <div class="basis-1/6">
                                <label class="label">
                                    <span class="label-text">Moneda</span>
                                </label>
                                <select v-model="this.form.currency"
                                        @change="onChangeCurrency"
                                        class="select select-sm select-bordered w-full">
                                    <option value="PEN">S/.</option>
                                    <option value="USD">US$</option>
                                </select>
                            </div>
                            <div class="basis-1/6">
                                <label class="label">
                                    <span class="label-text">Factor</span>
                                </label>
                                <input v-model="this.form.factor2" 
                                        type="number"
                                        min=0
                                        step=0.05
                                        class="input input-sm input-bordered w-full" 
                                />
                            </div>
                            <div class="basis-2/6">
                                <label class="label">
                                    <span class="label-text">Dia de pagos</span>
                                </label>
                                <input v-model="form.payment_day" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                            </div>          
                        </div>
                        <div class="flex space-x-4">
                            <div class="form-control basis-2/3">
                                <label class="label">
                                    <span class="label-text">Contacto para pago</span>
                                </label>
                                <input v-model="form.payment_contact" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                            </div>
                            <div class="form-control basis-1/3">
                                <label class="label">
                                    <span class="label-text">Teléfono pagos</span>
                                </label>
                                <input v-model="form.payment_phone" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                            </div>
                        </div>
                        <div class="flex flex-col xl:flex-row xl:max-w-4xl justify-between w-full mx-auto mt-12">
                            <button type="submit" class="btn btn-md bg-indigo-700 hover:bg-indigo-900 xl:max-w-xs w-full mx-auto text-lg">
                                <InboxIcon class="w-5 h-5"></InboxIcon>
                                <span class="ml-2">Guardar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            
        </jet-modal>
        <jet-modal :show="showmodalDelete" :closeable="true" @close="showmodalDelete = null" maxWidth="md">
            <div class="flex flex-row p-12 justify-center">
                <form @submit.prevent="submit" >
                    <div>¿Desea eliminar el cliente <b>{{ this.select.name }}</b>?</div>
                    <div class="flex flex-row mx-auto justify-evenly  pt-6 ">
                        <button class="btn btn-sm bg-red-700 hover:bg-red-900 px-6"
                                type="submit">
                            Si
                        </button>
                        <button class="btn btn-sm bg-indigo-700 hover:bg-indigo-900 px-6"
                                @click="this.resetActions();"
                                type="button">
                            No
                        </button>
                    </div>
                </form>
            </div>
        </jet-modal>
    </AppLayout>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetLabel from "@/Components/InputLabel.vue";
    import JetInput from "@/Components/Input.vue";
    import JetInputError from "@/Components/InputError.vue";
    import JetModal from '@/Components/Modal.vue';
    import Pagination from '@/Components/Pagination.vue'
    import axios from 'axios';
    import { useToast } from "vue-toastification";
    import { PencilIcon,TrashIcon,DocumentIcon,PlusIcon,InboxIcon,MagnifyingGlassIcon } from '@heroicons/vue/24/solid';

    //const options = {};
    //Vue.use(Toast, options);

    export default {
        components: {
            AppLayout,
            JetLabel,
            JetInput,
            JetInputError,
            JetModal,
            Pagination,
            axios,
            PencilIcon,
            TrashIcon,
            DocumentIcon,
            InboxIcon,
            PlusIcon,
            MagnifyingGlassIcon,
        },
        setup() {
            // Get toast interface
            const toast = useToast();
            const toast_options = {
                position: "bottom-left",
                timeout: 3000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: true,
                closeButton: "button",
                icon: true,
                rtl: false
            };

            // Use it!
            //toast("I'm a toast!");

            // or with options
            // toast.success("My toast content", {
            //     timeout: 2000
            // });
            // These options will override the options defined in the "app.use" plugin registration for this specific toast

            // Make it available inside methods
            return { toast,toast_options }
        },
        mounted(){
                let rolesadm = this.$page.props.user.roles.filter(function(value){
                    return value.id === 1;
                });
                this.isAdmin = rolesadm.length>0;
            },
        data() {
            return{
                showmodal:null,
                showmodalDelete:null,
                showmodalView:null,
                method: null,
                action: null,
                select:[],
                item:[],
                resource:'customers',
                isAdmin:null,
                form: this.$inertia.form({
                    id: null,
                    code:null,
                    document_type:'ruc',
                    document_number:null,
                    name:null,
                    address:null,
                    phone:null,
                    email:null,
                    payday:this.default_payday,
                    currency:'PEN',
                    factor2:1,
                    contact:null,
                    payment_day:null,
                    payment_phone:null,
                    payment_contact:null,
                }),
            }
        },
        methods: {
            submit(){
                this.form.submit( this.method, this.action, {
                    onFinish: () => {
                        switch(this.response){
                            case 'OK':
                                this.resetActions();
                                this.toast.success(this.message, this.toast_options);
                                location.reload();
                                break;
                            case 'Delete':
                                this.resetActions();
                                this.toast.warning(this.message, this.toast_options);
                                location.reload();
                                break;
                            case 'Error':
                                this.toast.error(this.message, this.toast_options);
                                break;
                        }
                    },
                });
            },
            onNew(){
                this.resetActions();
                this.showmodal = true;
                this.method = 'post';
                this.action = route(`${this.resource}.store`);
            },
            onDelete(item){
                this.showmodalDelete = true;
                this.select = item;
                this.method = 'delete';
                this.action = route(`${this.resource}.destroy`, [item.id]);
            },
            onEdit(item){
                this.resetActions();
                this.select = item;
                this.form.id =  item.id;
                this.form.code = item.code;
                this.form.document_type = item.document_type;
                this.form.document_number = item.document_number;
                this.form.name = item.name;
                this.form.address = item.address;
                this.form.phone = item.phone;
                this.form.email = item.email;
                this.form.payday = item.payday;
                this.form.currency = item.currency;
                this.form.factor2 = item.factor2;
                this.form.contact = item.contact;
                this.form.payment_day = item.payment_day;
                this.form.payment_phone = item.payment_phone;
                this.form.payment_contact = item.payment_contact;

                this.showmodal = true;
                this.method = 'put';
                this.action = route(`${this.resource}.update`,[item.id]);
            },
            resetActions(){
                this.showmodal=null;
                this.showmodalDelete=null;
                this.showmodalView=null;
                this.method=null;
                this.action=null;
                this.form.id =  null;
                this.form.code = null;
                this.form.document_type = 'ruc';
                this.form.document_number = null;
                this.form.name = null;
                this.form.address = null;
                this.form.phone = null;
                this.form.email = null;
                this.form.payday = this.default_payday;
                this.form.currency = 'PEN';
                this.form.factor2 = 1;
                this.form.contact = null;
                this.form.payment_day = null;
                this.form.payment_phone = null;
                this.form.payment_contact = null;
                //console.log(this.select);
            },
            searchRUC(){
                if(this.form.document_number!=''){
                    axios.get(`/search/ruc/${this.form.document_number}`).then( response =>{
                        console.log(response.data);
                        if(response.data.success){
                            this.form.name = response.data.data.name;
                            this.form.address = response.data.data.address;
                        }
                        else{
                            this.toast.error(response.data.message, this.toast_options);
                        }
                    }).catch( errors => {
                        console.log(response.errors);
                    });
                }
            },
        },
        props: {
            items: Object,
            default_payday: Number,
            message: String,
            response: String,
        },
    }
</script>