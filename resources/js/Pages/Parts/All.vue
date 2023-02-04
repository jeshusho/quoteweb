<template>
    <AppLayout title="Clientes">
        <template  #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Repuestos
                </h2>
                <div class="flex flex-row space-x-6 items-center">
                    <button @click.prevent="onNew"
                        class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded flex flex-row space-x-2 text-sm items-center">
                        <PlusIcon class="w-6 h-6"></PlusIcon>
                        <span>NUEVO REPUESTO</span>
                    </button>
                </div>
                
            </div>

        </template>

        <div class="container mx-auto max-w-3xl my-10 overflow-x-auto">
            <table v-if="items.data.length>0" class="table table-zebra w-full">
                <!-- head -->
                <thead>
                <tr>
                    <th class="w-1/12 px-2 py-4 text-center"></th>
                    <th class="w-9/12 px-2 py-4">Descripción</th>
                    <th class="w-1/12 px-2 py-4 text-center">Acción</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in items.data" :key="index"
                    class="text-sm text-indigo-900"
                >   
                    <td class="px-2 py-4 text-center">
                        {{ index+1 }}
                    </td>
                    <td class="px-2 py-4">
                        {{ item.description }}
                    </td>
                    <td class="px-2 py-4 flex flex-row justify-start space-x-4">                       
                        <button @click.prevent="onEdit(item)">
                            <PencilIcon class="h-6 w-6 text-blue-700"/>
                        </button>
                        <button @click.prevent="onDelete(item)">
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
                No hay repuestos creados aún
            </div>
        </div>
        <jet-modal :show="showmodal" :closeable="true" @close="showmodal = null" maxWidth="2xl">
            <div class="py-6 mb-4 max-w-xl mx-auto">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                    <span v-if="this.select.length===0">Nuevo Servicio</span>
                    <span v-else>Editar servicio: {{ this.select.description }}</span>
                </h2>
                <hr>
                <form @submit.prevent="submit" >
                    <div class="justify-center w-full">
                        <div class="flex flex-row w-full space-x-4 items-end ">
                            <div class="form-control basis-4/5">
                                <label class="label">
                                    <span class="label-text">Descripción</span>
                                </label>
                                <input v-model="form.description" type="text" placeholder="" class="input input-bordered input-sm w-full" required />
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
                    <div>¿Desea eliminar el repuesto <b>{{ this.select.description }}</b>?</div>
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
    import { PencilIcon,TrashIcon,DocumentIcon,PlusIcon,InboxIcon,PlusCircleIcon,XCircleIcon} from '@heroicons/vue/24/solid';

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
            PlusCircleIcon,
            XCircleIcon,
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
        data() {
            return{
                showmodal:null,
                showmodalDelete:null,
                showmodalView:null,
                method: null,
                action: null,
                select:[],
                item:[],
                resource:'parts',
                form: this.$inertia.form({
                    id: null,
                    description:null,
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
                console.log(item);
                this.select = item;
                this.form.id = item.id;
                this.form.description = item.description;

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

                this.form.id = null;
                this.form.description = null;
            },
        },
        props: {
            items: Object,
            message: String,
            response: String,
        },
    }
</script>