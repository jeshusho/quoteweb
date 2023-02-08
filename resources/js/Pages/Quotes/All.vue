<template>
    <AppLayout title="Presupuestos">
        <template  #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Presupuestos
                </h2>
                <div class="flex flex-row space-x-6 items-center">
                    <div class="form-control">
                        <label class="input-group input-group-md">
                            <span class="w-36">Tipo de Cambio</span>
                            <input v-model="this.exchange_sell_temp" 
                                    type="number" step="0.001" placeholder="" 
                                    class="input input-sm input-bordered w-20"
                                    @blur="onBlurExchange"
                                    :readonly="!exchange_edit"
                            />
                            <button v-if="!exchange_edit"
                                    @click.prevent="this.exchange_edit=true;this.exchange_save=false;"
                                    class="btn btn-sm bg-gray-100 hover:bg-gray-300 text-indigo-600 border-gray-300 hover:border-gray-400 px-3 py-0">
                                        <PencilIcon class="w-5 h-5"></PencilIcon>
                            </button>
                            <button v-if="exchange_edit"
                                    @click.prevent="onChangeExchange"
                                    class="btn btn-sm bg-gray-100 hover:bg-gray-300 text-green-600 border-gray-300 hover:border-gray-400 px-3 py-0">
                                        <CheckIcon class="w-5 h-5"></CheckIcon>
                            </button>
                        </label>
                    </div>
                    <a :href="route('quotes.create')" :active="route().current('quotes.create')"
                        class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded flex flex-row space-x-2 text-sm items-center">
                        <PlusIcon class="w-6 h-6"></PlusIcon>
                        <span>NUEVO PRESUPUESTO</span>
                    </a>
                </div>
                
            </div>

        </template>

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div> -->
        <div class="container mx-auto 2xl:max-w-screen-2xl xl:max-w-7xl my-10 overflow-x-auto">
            <table v-if="quotes.data.length>0" class="table table-zebra w-full">
                <!-- head -->
                <thead>
                <tr>
                    <th class="w-1/12 px-2 py-4 text-center">Presupuesto</th>
                    <th class="w-1/12 px-2 py-4 text-center">Fecha</th>
                    <th class="w-5/12 px-2 py-4">Cliente</th>
                    <th class="w-1/12 px-2 py-4 text-center">Monto</th>
                    <th class="w-2/12 px-2 py-4 text-center">Fecha entrega</th>
                    <th class="w-1/12 px-2 py-4 text-center">Estado</th>
                    <th class="w-1/12 px-2 py-4 text-center">Acción</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(quote,index) in quotes.data" :key="index"
                    class="text-sm text-indigo-900"
                >   
                    <td class="px-2 py-4 text-center">
                        {{ quote.number }}
                    </td>
                    <td class="px-2 py-4 text-center">
                        {{ quote.fecha_creacion }}
                    </td>
                    <td class="px-2 py-4">
                        {{ quote.name }}
                    </td>
                     <td class="px-2 py-4 text-right">
                        {{ quote.symbol }}
                        {{ quote.total.toFixed(2) }}
                    </td>
                    <td class="px-2 py-4 text-center">
                        <div v-if="quote.fecha_programada!==null">{{ quote.fecha_programada }} (Prevista)</div>
                        <div v-if="quote.fecha_ejecucion!==null">{{ quote.fecha_ejecucion }} (Realizada)</div>
                    </td>
                    <td class="px-2 py-4 text-center">
                        {{ quote.estado }}
                    </td>
                    <td class="px-2 py-4 flex flex-row justify-start space-x-2">
                        <a :href="route('quotes.pdf',[quote.external_id])" target="_blank">
                            <DocumentIcon class="h-6 w-6 text-gray-600"/>
                        </a>
                        
                        <a :href="route('quotes.edit',[quote.id])">
                            <PencilIcon class="h-6 w-6 text-blue-700"/>
                        </a>
                        <button @click.prevent="this.showmodal = true;
                                                this.selectQuote = quote;
                                                method = 'delete';
                                                action = route('quotes.destroy', [quote.id]);
                            ">
                            <TrashIcon class="h-6 w-6 text-red-700"/>
                        </button>
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="text-center pt-5">                               
                        <nav aria-label="Page navigation example">
                            <ul class="inline-flex -space-x-px">
                                <li v-for="(l,index) in quotes.links" :key="index">
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
                No hay presupuestos creados aún
            </div>
        </div>
        <jet-modal :show="showmodal" :closeable="true" @close="showmodal = null" maxWidth="md">
            <div class="flex flex-row p-12">
                <form @submit.prevent="submit" >
                    <div>¿Desea eliminar el Presupuesto No. {{ this.selectQuote.number }}?</div>
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
    import { PencilIcon,TrashIcon,DocumentIcon,PlusIcon,CheckIcon } from '@heroicons/vue/24/solid'

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
            PlusIcon,
            CheckIcon,
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
            return { toast,toast_options }
        },
        mounted(){
            this.exchange_sell = this.exchange.sell;
            this.exchange_sell_temp = this.exchange.sell;
            this.exchange_rate = this.exchange.exchange_rate;
        },
        data() {
            return{
                showmodal:null,
                method: null,
                action: null,
                selectQuote:[],
                exchange_sell:null,
                exchange_rate:null,
                exchange_edit:false,
                exchange_save:false,
                exchange_sell_temp:null,
                form: this.$inertia.form({
                    id: null,
                }),
            }
        },
        methods: {
            submit(){
                this.form.submit( this.method, this.action, {
                        onSuccess: () => {
                            //if(this.action=='delete')
                            this.resetActions();
                        }
                    });
            },
            resetActions(){
                this.showmodal=null;
                this.selectQuote=[];
                this.method=null;
                this.action=null;
            },
            async onChangeExchange(){
                this.exchange_sell= this.exchange_sell_temp;
                this.exchange_edit=false;
                this.exchange_save=true;
                this.exchange.sell=this.exchange_sell;
                await axios.put(`/exchanges/${this.exchange.id}`,this.exchange).then( response =>{
                        if(response.data.success){
                            console.log(response.data);
                           this.exchange_rate = response.data.data.exchange_rate;
                           this.toast.success(response.data.message, this.toast_options);
                        }
                        else{
                            this.toast.error(response.data.message, this.toast_options);
                        }
                    }).catch( errors => {
                        console.log(response.errors);
                    });                
            },
            onBlurExchange(){
                setTimeout(function(){
                   if(this.exchange_edit && !this.exchange_save){
                        this.exchange_sell_temp= this.exchange_sell;
                        this.exchange_edit=false;
                        this.exchange_save=true;
                   }
                   
                }.bind(this, this.exchange_edit,this.exchange_save,this.exchange_sell, this.exchange_sell_temp), 1000);
            }
        },
        props: {
            quotes: Object,
            exchange: Object,
        },
    }
</script>