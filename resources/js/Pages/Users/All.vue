<template>
    <AppLayout title="Usuarios">
        <template  #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Usuarios
                </h2>
                <div class="flex flex-row space-x-6 items-center">
                    <button @click.prevent="onNew"
                        class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded flex flex-row space-x-2 text-sm items-center">
                        <PlusIcon class="w-6 h-6"></PlusIcon>
                        <span>NUEVO USUARIO</span>
                    </button>
                </div>
                
            </div>

        </template>

        <div class="container mx-auto max-w-4xl my-10 overflow-x-auto">
            <table v-if="items.data.length>0" class="table table-zebra w-full">
                <!-- head -->
                <thead>
                <tr>
                    <th class="w-1/12 px-2 py-4 text-center"></th>
                    <th class="w-3/12 px-2 py-4">Nombre</th>
                    <th class="w-3/12 px-2 py-4">E-mail</th>
                    <th class="w-3/12 px-2 py-4">Roles</th>
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
                        {{ item.name }}
                    </td>
                    <td class="px-2 py-4">
                        {{ item.email }}
                    </td>
                    <td class="px-2 py-4">
                        {{ item.strRoles }}
                    </td>
                    <td class="px-2 py-4 flex flex-row justify-start space-x-4">                       
                        <button @click.prevent="onEdit(item)">
                            <PencilIcon class="h-6 w-6 text-blue-700"/>
                        </button>
                        <button v-if="item.id>1" @click.prevent="onDelete(item)">
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
                No hay usuarios creados aún
            </div>
        </div>
        <jet-modal :show="showmodal" :closeable="true" @close="showmodal = null" maxWidth="xl">
            <div class="py-6 mb-4 max-w-lg mx-auto">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                    <span v-if="this.select.length===0">Nuevo Usuario</span>
                    <span v-else>Editar usuario: {{ this.select.name }}</span>
                </h2>
                <hr>
                <form @submit.prevent="submit" >
                    <div class="justify-center w-full">
                        <div class="flex flex-row w-full space-x-4 items-end ">
                            <div class="form-control basis-2/5">
                                <label class="label">
                                    <span class="label-text">Nombre</span>
                                </label>
                                <input v-model="form.name" type="text" placeholder="" class="input input-bordered input-sm w-full" required />
                            </div>
                            <div class="form-control basis-3/5">
                                <label class="label">
                                    <span class="label-text">E-mail</span>
                                </label>
                                <input v-model="form.email" type="email" placeholder="" class="input input-bordered input-sm w-full" required />
                            </div>
                        </div>
                        <div class="flex flex-row space-x-4 pt-4 items-end ">
                            <div class="form-control basis-4/5">
                                <label class="label">
                                    <span class="label-text">Roles:</span>
                                </label>
                            </div>
                        </div>
                       <div v-if="this.form.id!==1" class="flex flex-row space-x-4 items-end ">
                            <div v-for="(item,index) in this.rolesByUser" :key="index"  class="form-control basis-2/6">
                                <label class="label cursor-pointer justify-evenly">
                                    <span class="label-text">{{item.title}}</span> 
                                    <input  type="checkbox" :checked="item.value"
                                            @change="onChangeRol(item,$event)"
                                            class="checkbox checkbox-primary" />
                                </label>
                            </div>
                        </div>
                        <div v-else class="label justify-evenly label-text">Administrador</div>

                        <div class="flex flex-row w-full space-x-4 items-end ">
                            <div class="form-control basis-2/5">
                                <label class="label">
                                    <span class="label-text">Nueva contraseña</span>
                                </label>
                                <input v-model="form.password" type="password" placeholder="" class="input input-bordered input-sm w-full" :required="this.form.id===null" />
                            </div>
                        </div>
                       
                        <div class="flex flex-col xl:flex-row xl:max-w-4xl justify-between w-full mx-auto mt-12">
                            <button type="submit" :disabled="this.form.roles.length===0" class="btn btn-md bg-indigo-700 hover:bg-indigo-900 xl:max-w-xs w-full mx-auto text-lg">
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
                resource:'users',
                rolesByUser:[],
                form: this.$inertia.form({
                    id: null,
                    name:null,
                    email:null,
                    password:null,
                    roles:[],
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
                this.form.id = item.id;
                this.form.name = item.name;
                this.form.email = item.email;
                this.form.password = null;
                this.form.roles = [];
                this.rolesByUser=[];
                this.roles.forEach(element => {
                    let indexr = item.roles.findIndex( function(rol){
                        return rol.id === element.id;
                    });
                    this.rolesByUser.push({
                        'id': element.id,
                        'title': element.title,
                        'value': (indexr>=0) ? true : false,
                     });
                     if(indexr>=0){
                        this.form.roles.push(element.id);
                     }

                });

                this.showmodal = true;
                this.method = 'put';
                this.action = route(`${this.resource}.update`,[item.id]);
            },
            onChangeRol(item,ev){
                //console.log(item.id);
                //console.log(ev.target.checked);
                if(ev.target.checked){
                    this.form.roles.push(item.id)
                }
                else{
                    let filter = this.form.roles.filter( obj => {
                        return obj !== item.id;
                    });
                    this.form.roles = filter;
                }
            },
            resetActions(){
                this.showmodal=null;
                this.showmodalDelete=null;
                this.showmodalView=null;
                this.method=null;
                this.action=null;
                this.select=[];
                this.form.id = null;
                this.form.name = null;
                this.form.email = null;
                this.form.password = null;
                this.form.roles = [];
                this.rolesByUser=[];
                this.roles.forEach(element => {
                    this.rolesByUser.push({
                        'id': element.id,
                        'title': element.title,
                        'value': false,
                     });
                });
            },
        },
        props: {
            items: Object,
            roles: Object,
            message: String,
            response: String,
        },
    }
</script>