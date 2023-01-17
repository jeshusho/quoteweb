<template>
    <AppLayout title="Nuevo Presupuesto">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Nuevo Presupuesto
                </h2>
                <a :href="route('quotes.index')" :active="route().current('quotes.index')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Volver a lista
                </a>
            </div>
        </template>
        <div>
            <div class="container mx-auto max-w-6xl my-4 overflow-x-auto p-2">
                <form @submit.prevent="submit" >
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Cliente</span>
                    </label>
                    <input type="text"
                            v-model="searchTermCustomer"
                            placeholder="Código, razón social o RUC"
                            class="input text-gray-400 input-bordered w-full"
                            @click="resetCustomer"
                            @input="onInputCustomer"
                            @keydown.enter.prevent="onSelectedFirstCustomer"
                            @keydown.tab.prevent="onSelectedFirstCustomer"
                            
                    />
                    <label class="label">
                        <span class="label-text-alt"></span>
                        <span class="label-text-alt">Escriba al menos 2 caracteres</span>
                    </label>
                </div>
                <div  v-if="this.searchTermCustomer.length>1" class="max-w-6xl w-full ">
                    <ul class="menu bg-base-100 rounded-box z-0 relative block w-full -my-8">
                            <li v-for="customer in customers"
                                :key="customer.id" 
                                @click="onSelectedCustomer(customer)"
                                class="p-2 first:bg-base-200 hover:bg-base-200"
                            >
                                {{ customer.label }}
                            </li>
                    </ul>
                </div>
                <div class="flex space-x-4 mt-4">
                        <div class="form-control basis-2/3 w-full">
                            <label class="label">
                                <span class="label-text">Nombre o Razón social</span>
                            </label>
                            <input v-model="form.name" type="text" placeholder="" class="input input-bordered input-sm w-full" />
                        </div>
                        <div class="form-control basis-1/3 w-full">
                            <label class="label">
                                <span class="label-text">Documento</span>
                            </label>
                            <div class="input-group">
                                <select v-model="form.document_type" class="select select-sm select-bordered bg-gray-100">
                                <option value=null disabled selected>Tipo</option>
                                <option value="ruc">RUC</option>
                                <option value="dni">DNI</option>
                                <option value="ce">CE</option>
                                <option value="passport">PASAPORTE</option>
                                <option value="other">OTRO</option>
                                </select>
                                <input v-model="form.document_number" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                            </div>
                        </div>
                </div>
                <div class="flex space-x-4">
                        <div class="form-control basis-2/3 w-full">
                            <label class="label">
                                <span class="label-text">Dirección</span>
                            </label>
                            <input v-model="form.address" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                        </div>
                        <div class="form-control basis-1/3 w-full">
                            <label class="label">
                                <span class="label-text">Teléfono</span>
                            </label>
                            <input v-model="form.phone" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                        </div>
                </div>
                <div class="flex space-x-4">
                        <div class="form-control basis-2/3 w-full">
                            <label class="label">
                                <span class="label-text">Atención a</span>
                            </label>
                            <input v-model="form.contact" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                        </div>
                        <div class="form-control basis-1/3 w-full">
                            <label class="label">
                                <span class="label-text">E-mail</span>
                            </label>
                            <input v-model="form.email" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                        </div>
                </div>
                <div class="flex flex-col w-full border-opacity-50 my-6">
                    <div class="grid h-12 card bg-base-300 rounded-box place-items-center">SERVICIOS</div>
                </div>
                <div class=" my-4">
                    <div class="w-full">
                        <div class="flex space-x-4">
                            <span class="basis-1/12"></span>
                            <span class="basis-1/12">Código</span>
                            <span class="basis-5/12">Descripción</span>
                            <span class="basis-1/12">Medida</span>
                            <span class="basis-1/12">Cantidad</span>
                            <span class="basis-1/12">PU</span>
                            <span class="basis-1/12">Parcial</span>
                            <span class="basis-1/12"></span>
                        </div>
                        <div v-for="(service,index) in quoteServices"
                            :key="service.id"
                            class="my-2"
                            >
                            <div class="flex flex-row hover space-x-4">
                                <div class="basis-1/12">{{index+1}}</div>
                                <div class="basis-1/12">
                                    <input v-model="service.code" 
                                            @input="onInputService(index)"
                                            @blur="onSelectedFirstService(index)"
                                            @keydown.enter.prevent="onSelectedFirstService(index)"
                                            @keydown.tab.prevent="$event.target.blur()"
                                            type="text" placeholder=""
                                            class="input input-sm input-bordered w-full" 
                                    /></div>
                                <div class="basis-5/12">
                                    <input v-model="service.description"
                                            type="text" placeholder="" 
                                            class="input input-sm input-bordered w-full"  
                                    /></div>
                                <div class="basis-1/12"><input v-if="service.have_measures" v-model="service.measure" type="text" placeholder="" class="input input-sm input-bordered w-full"  /></div>
                                <div class="basis-1/12">
                                    <input v-model="service.quantity"
                                            type="number"
                                            placeholder=""
                                            @input="service.subtotal=(service.quantity*service.unit_price).toFixed(2)"
                                            class="input input-sm input-bordered w-full"  
                                    /></div>
                                <div class="basis-1/12">
                                    <input v-model="service.unit_price"
                                            type="number"
                                            placeholder=""
                                            @input="service.subtotal=(service.quantity*service.unit_price).toFixed(2)"
                                            class="input input-sm input-bordered w-full" 
                                    /></div>
                                <div class="basis-1/12"><input v-model="service.subtotal" type="number" placeholder="" class="input input-sm input-bordered w-full" readonly /></div>
                                <div class="basis-1/12">
                                    <button v-if="index>0" class="btn btn-sm bg-red-800 text-white mr-2" @click="deleteService(index)">x</button>
                                    <button v-if="index==quoteServices.length-1" class="btn btn-sm hover:bg-blue-900 bg-blue-800 text-white" @click="addService">+</button>
                                </div>
                            </div>
                            <div  v-if="service.code.length>0" class="max-w-6xl w-full ">
                            <ul class="menu bg-base-100 z-0 relative block w-full my-2">
                                <li v-for="srv in services"
                                    :key="srv.id" 
                                    @click="onSelectedService(srv,index)"
                                    class="p-2 first:bg-base-200 hover:bg-base-200"
                                >
                                    {{ srv.label }}
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>            
        </div>
    </AppLayout>
</template>


<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetLabel from "@/Components/InputLabel.vue";
    import JetInput from "@/Components/Input.vue";
    import JetInputError from "@/Components/InputError.vue";
    /*import VueMultiselect from 'vue-multiselect';
    import Multiselect from '@vueform/multiselect'
    import {throttle} from "lodash";*/

    export default {
        components: {
            AppLayout,
            JetLabel,
            JetInput,
            JetInputError,
        },
        data() {
            return{
                selectedCustomer: undefined,
                searchTermCustomer:'',
                selectedService: undefined,
                searchTermService:'',
                customers: {
                    type: Array,
                    default: () => []
                },
                services: {
                    type: Array,
                    default: () => []
                },
                newparts: {
                    type: Array,
                    default: () => []
                },
                quoteServices:[
                    {
                        id: null,
                        code:'',
                        description: '',
                        measure: null,
                        quantity: null,
                        unit_price: null,
                        subtotal: null,
                        have_measures: false,
                        have_parts: false,
                        is_qty: false,
                    }
                ],
                quoteParts:{
                    type: Array,
                    default: () => []
                },
                //currentService = quoteServices[0],
                form: this.$inertia.form({
                    customer_id: null,
                    document_type: null,
                    document_number: null,
                    name: null,
                    address: null,
                    phone: null,
                    email: null,
                    contact: null,
                }),
            }
        },
        methods: {
            async fetchCustomers(){
                const  r =  axios.get('/quotes/searchcustomers/'+ this.searchTermCustomer).then( response => response.data);
                return await r;
            },
            async onInputCustomer(){
                if(this.searchTermCustomer.length>1){
                    axios.get('/quotes/searchcustomers/'+ this.searchTermCustomer).then( response =>{
                        this.customers = response.data;
                    }).catch( errors => {
                        this.errors = error.reponse.errors
                    });
                }
            },
            async onInputService(index){
                //if(this.quoteServices.indexOf(index).code.length>1){
                    const term = this.quoteServices[index].code;
                    axios.get('/quotes/searchservices/'+ term).then( response =>{
                        this.services = response.data;
                        console.log(this.services);
                    }).catch( errors => {
                        this.errors = error.reponse.errors
                    });
                //}
            },
            async getParts(id) {
                    try{
                        let res =  axios.get('/quotes/selectedservice/'+ id);
                        return res.data;
                        //this.newparts = res.data;
                    } catch(err){
                        console.error(err);
                    }
                    //return await res.data;

                    // await axios.get('/quotes/selectedservice/'+ id).then( response =>{
                    //     console.log('getParts',response.data);
                    //     this.newparts = response.data;
                    //     console.log(this.newparts);
                    //     //this.services = response.data;
                        
                    //     // this.newparts = response.data;
                    //     // if(this.newparts.length>0){
                    //     //     this.newparts.forEach(function (element) {
                    //     //         console.log(element);
                    //     //         // part = {
                    //     //         //     id: element.id,
                    //     //         //     description: element.description,
                    //     //         // //    quantity: element.pivot.part_qty,
                    //     //         // //    measure: '' //element.pivot.measure
                    //     //         // }
                    //     //         this.quoteParts.push(element);
                    //     //     //     //console.log(quoteParts);
                    //     //     //     console.log(part);
                    //     //     });
                    //     // }
                    // }).catch( errors => {
                    //     this.errors = error.response.errors
                    // });
            },
            onSelectedCustomer(customer) {
                this.selectedCustomer = customer;
                this.form.customer_id = customer.id;
                this.form.document_type = customer.document_type;
                this.form.document_number = customer.document_number;
                this.form.name = customer.name;
                this.form.address = customer.address;
                this.form.phone = customer.phone;
                this.form.email = customer.email;
                this.form.contact = customer.contact;
                this.searchTermCustomer = customer.label;
                this.customers=[];
                //console.log(this.form);
            },
            addService(){
                this.quoteServices.push({
                        id: null,
                        code:'',
                        description: '',
                        measure: null,
                        quantity: null,
                        unit_price: null,
                        subtotal: null,
                        have_measures: false,
                        have_parts: false,
                        is_qty: false,
                });
            },
            deleteService(index){
                this.quoteServices.splice(index,1);
            },
            async onSelectedService(service,index) {
                this.selectedService = service;
                console.log('service',service);
                this.quoteServices[index] = {
                    id: service.id,
                    code: service.code,
                    description: service.description,
                    unit_price: service.unit_price,
                    have_measures: service.have_measures,
                    have_parts: service.have_parts,
                    is_qty: service.is_qty,
                    quantity: 1,
                    subtotal: service.unit_price,
                }
                this.newparts = await this.getParts(service.id);
                console.log('this.newparts',this.newparts);
                if(this.newparts.length>0){
                    this.newparts.forEach(function (element) {
                        console.log(element);
                        // part = {
                        //     id: element.id,
                        //     description: element.description,
                        // //    quantity: element.pivot.part_qty,
                        // //    measure: '' //element.pivot.measure
                        // }
                        this.quoteParts.push(element);
                    //     //console.log(quoteParts);
                    //     console.log(part);
                    });
                }
                console.log(this.quoteParts);
                this.services=[];
                
                //console.log(this.form);
            },

            onSelectedFirstCustomer() {
                //console.log(customer);
                if(this.customers.length>0){
                    this.selectedCustomer = this.customers[0];      
                    console.log('selectedCustomer',this.selectedCustomer);
                    this.form.customer_id = this.selectedCustomer.id;
                    this.form.document_type = this.selectedCustomer.document_type;
                    this.form.document_number = this.selectedCustomer.document_number;
                    this.form.name = this.selectedCustomer.name;
                    this.form.address = this.selectedCustomer.address;
                    this.form.phone = this.selectedCustomer.phone;
                    this.form.email = this.selectedCustomer.email;
                    this.form.contact = this.selectedCustomer.contact;
                    this.searchTermCustomer = this.selectedCustomer.label;
                    this.customers=[];
                }
                //console.log(this.form);
            },
            sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            },
            onSelectedFirstService(index) {
                //console.log(customer);
                if(this.services.length>0){
                    this.selectedService = this.services[0];      
                    console.log('selectedService',this.selectedService);
                    this.quoteServices[index] = {
                        id: this.selectedService.id,
                        code: this.selectedService.code,
                        description: this.selectedService.description,
                        unit_price: this.selectedService.unit_price,
                        have_measures: this.selectedService.have_measures,
                        have_parts: this.selectedService.have_parts,
                        is_qty: this.selectedService.is_qty,
                        quantity: 1,
                        subtotal: this.selectedService.unit_price,
                    }
                    
                    console.log("Hello");
                    this.sleep(2000).then(() => { this.newparts =  this.getParts(this.selectedService.id); });
                    //setTimeout(() => { this.newparts = await this.getParts(this.selectedService.id); }, 5000);
                    
                    console.log('this.newparts',this.newparts);
                    if(this.newparts.length>0){
                        this.newparts.forEach(function (element) {
                            console.log(element);
                            // part = {
                            //     id: element.id,
                            //     description: element.description,
                            // //    quantity: element.pivot.part_qty,
                            // //    measure: '' //element.pivot.measure
                            // }
                            this.quoteParts.push(element);
                        //     //console.log(quoteParts);
                        //     console.log(part);
                        });
                    }
                    console.log(this.quoteParts);
                    this.services=[];
                }
                else{
                    this.quoteServices[index] = {
                        id: null,
                        code:'',
                        description: '',
                        measure: null,
                        quantity: null,
                        unit_price: null,
                        subtotal: null,
                        have_measures: false,
                        have_parts: false,
                        is_qty: false,
                    }
                }
                //console.log(this.form);
            },


            resetCustomer(){
                if(this.selectedCustomer != undefined){
                    this.searchTermCustomer='';
                    this.form.customer_id = null;
                    this.form.document_type = null;
                    this.form.document_number = null;
                    this.form.name = null;
                    this.form.address = null;
                    this.form.phone = null;
                    this.form.email = null;
                    this.form.contact = null;
                }
            }



            // submit() {
            //     this.form.submit( this.method, this.action, {
            //         onSuccess: () => {
            //             this.form.reset('zendesk_group_id');
            //             this.form.reset('zendesk_tickettype_id');
            //             this.form.reset('zendesk_priority_id');
            //             this.form.reset('sla_hours');
            //             this.acting = null;
            //         }
            //     });
            // },
            // defaultsubmit() {
            //     this.formdefault.submit( this.method, this.action, {
            //         onSuccess: () => {
            //             this.formdefault.reset('zendesk_tickettype_id');
            //             this.formdefault.reset('zendesk_priority_id');
            //             this.formdefault.reset('sla_hours');
            //             this.defaultacting = null;
            //         }
            //     });
            // }
        },
        // props: {
        //     customers: {
        //         type: Array,
        //         default: () => []
        //     },
        // },
    }
</script>