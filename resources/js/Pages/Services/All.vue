<template>
    <AppLayout title="Servicios">
        <template  #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Servicios
                </h2>
                <div class="flex flex-row space-x-6 items-center">
                    <button @click.prevent="onNew"
                        class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded flex flex-row space-x-2 text-sm items-center">
                        <PlusIcon class="w-6 h-6"></PlusIcon>
                        <span>NUEVO SERVICIO</span>
                    </button>
                </div>
                
            </div>

        </template>

        <div class="container mx-auto max-w-3xl my-10 overflow-x-auto">
            <table v-if="items.data.length>0" class="table table-zebra w-full">
                <!-- head -->
                <thead>
                <tr>
                    <th class="w-1/12 px-2 py-4 text-center">Código</th>
                    <th class="w-9/12 px-2 py-4">Actividad</th>
                    <th class="w-1/12 px-2 py-4">Precio</th>
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
                        {{ item.description }}
                    </td>
                    <td class="px-2 py-4 text-right">
                        {{ item.price }}
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
                No hay servicios creados aún
            </div>
        </div>
        <jet-modal :show="showmodal" :closeable="true" @close="showmodal = null" maxWidth="3xl">
            <div class="py-6 mb-4 max-w-2xl mx-auto">
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
                                    <span class="label-text">Actividad</span>
                                </label>
                                <input v-model="form.description" type="text" placeholder="" class="input input-bordered input-sm w-full" required />
                            </div>
                            <div class="form-control basis-1/5">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Variable</span> 
                                    <input  v-model="this.form.is_variable"
                                            @change="(this.form.is_variable)?this.form.unit_price=null:this.form.unit_price=0"
                                            type="checkbox" class="toggle" :true-value=1 :false-value=0 />
                                </label>
                            </div>
                        </div>
                       
                        <div class="flex flex-row w-full space-x-4">
                            <div class="form-control basis-1/6">
                                <label class="label">
                                    <span class="label-text">Código</span>
                                </label>
                                <input v-model="form.code" type="number" step="1" placeholder="" class="input input-sm input-bordered w-full" required />
                            </div>
                            <div class="form-control basis-3/6">
                                <label class="label">
                                    <span class="label-text">Grupo</span>
                                </label>
                                <select v-model="this.form.group_id"
                                        class="select select-sm select-bordered w-full">
                                    <option v-for="(group,index) in groups" :key="index" :value="group.id">{{group.description}}</option>
                                </select>
                            </div>
                            <div  class="basis-2/6">
                                <label v-if="!this.form.is_variable" class="label">
                                    <span class="label-text">Precio</span>
                                </label>
                                <div v-if="!this.form.is_variable" class="input-group">
                                    <span>S/.</span>
                                    <input  v-model="form.unit_price" 
                                            type="number"
                                            step="0.01"
                                            placeholder=""
                                            class="input input-sm input-bordered w-full"

                                    />
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row w-full space-x-4 items-end my-4">
                            <div class="form-control basis-2/6">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Requiere medidas</span> 
                                    <input  v-model="this.form.have_measures"
                                            @change="changeServiceMeasure"
                                            type="checkbox" class="toggle" :true-value=1 :false-value=0 />
                                </label>
                            </div>
                            <div class="form-control basis-2/6">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Cantidad C/U</span> 
                                    <input  v-model="this.form.is_qty"
                                            type="checkbox" class="toggle" :true-value=1 :false-value=0 />
                                </label>
                            </div>
                            <div class="form-control basis-2/6">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Requiere partes</span> 
                                    <input  v-model="this.form.have_parts"
                                            @change="(this.form.have_parts)?this.form.parts=this.selectParts:this.form.parts=[]"
                                            type="checkbox" class="toggle" :true-value=1 :false-value=0 />
                                </label>
                            </div>
                        </div>
                        <div class="flex flex-col w-full">
                            <div v-if="this.form.have_parts" 
                                class="flex flex-row h-10 card bg-base-300 rounded-box place-items-center justify-center space-x-4 text-md">
                                <span>REPUESTOS</span>
                                <button         v-if="this.form.parts.length==0"
                                                class="rounded-full p-0"
                                                @click.prevent="addPart">
                                                <PlusCircleIcon class="h-8 w-8 text-blue-800"/>
                                </button>
                            </div>
                            <div class="p-3 w-full">
                                <div v-if="this.form.parts.length>0" class="flex space-x-4 text-sm">
                                    <span>&nbsp;</span>
                                    <span class="basis-5/12">Descripción</span>
                                    <span class="basis-1/12">Cantidad</span>
                                    <span class="basis-4/12">Medida por defecto</span>
                                    <span class="basis-2/12"></span>
                                </div>
                                <div v-for="(part,index) in this.form.parts"
                                    :key="part.id"
                                    class="my-2"
                                    >
                                    <div class="flex flex-row hover space-x-4 items-center">
                                        <div class="text-sm">{{index+1}}</div>
                                        <div class="basis-5/12">
                                            <select v-model="part.id"
                                                    class="select select-sm text-xs select-bordered w-full">
                                                <option v-for="(p,index) in parts" :key="index" :value="p.id">{{p.description}}</option>
                                            </select>
                                        </div>
                                        
                                        <div class="basis-1/12">
                                            <input v-model="part.pivot.part_qty"
                                                    type="number"
                                                    step=1
                                                    min=1
                                                    pattern="\d*"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                                    placeholder=""
                                                    
                                                    class="input input-sm input-bordered text-xs text-right w-full"
                                                    
                                        /></div>
                                        <div class="basis-4/12">
                                            <label class="label cursor-pointer">
                                                <span class="label-text">De este servicio</span>
                                                <input  v-model="part.pivot.inherit_measure"
                                                        type="checkbox" class="toggle" :true-value=1 :false-value=0 />
                                            </label>
                                            <select v-if="!part.pivot.inherit_measure"
                                                    v-model="part.pivot.measure"
                                                    class="select select-sm text-xs select-bordered w-full">
                                                    <option :value="null">NINGUNA</option>
                                                    <option value="STD">Standard (STD)</option>
                                                    <option v-for="(s,index) in servicelist" :key="index" :value="s.code">{{ s.code }} - {{ s.description }}</option>
                                            </select>
                                        </div>
                                        <div class="basis-2/12 flex flex-row content-center">
                                            <button class="rounded-full p-0"
                                                    @click.prevent="deletePart(index)">
                                                    <XCircleIcon class="h-8 w-8 text-red-800 "/>
                                            </button>
                                            <button v-if="index==this.form.parts.length-1"
                                                    class="rounded-full p-0"
                                                    @click.prevent="addPart">
                                                    <PlusCircleIcon class="h-8 w-8 text-blue-800"/>
                                            </button>
                                        </div>

                                    </div>
                                </div>
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
                    <div>¿Desea eliminar el servicio <b>{{ this.select.description }}</b>?</div>
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
                selectParts:[],
                resource:'services',
                form: this.$inertia.form({
                    id: null,
                    group_id:null,
                    code:null,
                    description:null,
                    measure:null,
                    unit_price:null,
                    have_measures:true,
                    have_parts:false,
                    is_qty:true,
                    is_variable:false,
                    parts:[],
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
                console.log(this.groups);
                console.log(this.parts);
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
                this.selectParts = item.parts;
                this.select = item;
                this.form.id = item.id;
                this.form.group_id = item.group_id;
                this.form.code = item.code;
                this.form.description = item.description;
                this.form.measure = item.measure;
                this.form.unit_price = item.unit_price;
                this.form.have_measures = item.have_measures;
                this.form.have_parts = item.have_parts;
                this.form.is_qty = item.is_qty;
                this.form.is_variable = item.is_variable;
                this.form.parts = item.parts;

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
                this.form.group_id = null;
                this.form.code = null;
                this.form.description = null;
                this.form.measure = null;
                this.form.unit_price = null;
                this.form.have_measures = true;
                this.form.have_parts = false;
                this.form.is_qty = true;
                this.form.is_variable = false;
                this.form.parts = [];
                this.selectParts = [];
            },
            addPart(){
                this.form.parts.push({
                    id: null,
                    pivot: {
                        part_qty:null,
                        measure:null,
                        inherit_measure:this.form.have_measures,
                    }
                });
            },
            deletePart(index){
                this.form.parts.splice(index,1);
            },
            changeServiceMeasure(){
                if(!this.form.have_measures){
                    this.form.parts.forEach(element => {
                        element.pivot.inherit_measure = false;
                    });
                }

            }
        },
        props: {
            items: Object,
            groups: Object,
            parts: Object,
            servicelist: Object,
            default_payday: Number,
            message: String,
            response: String,
        },
    }
</script>