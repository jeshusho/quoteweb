<template>
    <AppLayout title="Nuevo Presupuesto">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <span v-if="this.dataquote===undefined">Nuevo Presupuesto</span>
                    <span v-else>Presupuesto No. {{ this.dataquote.number }}</span>
                </h2>
                <div class="flex flex-row space-x-6 items-center">
                    <span class="text-sm">Tipo de Cambio: {{this.exchange_sell}}</span>
                    <a :href="route('quotes.index')" :active="route().current('quotes.index')"
                        class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded flex flex-row space-x-2 text-sm items-center">
                        <ArrowSmallLeftIcon class="w-6 h-6"></ArrowSmallLeftIcon>
                        <span>VOLVER A LISTA</span>
                    </a>
                </div>
                
            </div>
        </template>
        <div>
            <div class="container mx-auto max-w-6xl my-4 overflow-x-auto p-2">
                <form @submit.prevent="submit" >
                <div v-if="this.dataquote===undefined" class="form-control w-full">
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
                                <button v-if="form.document_type==='ruc'"
                                        @click.prevent="searchRUC"
                                        class="btn btn-sm bg-gray-100 hover:bg-gray-300 text-indigo-600 border-gray-300 hover:border-gray-400 px-3 py-0">
                                            <MagnifyingGlassIcon class="w-5 h-5"></MagnifyingGlassIcon>
                                </button>
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
                <div class="flex space-x-4 mt-6">
                        <div class="form-control basis-1/3 w-full">
                            <label class="label">
                                <span class="label-text">Fecha Programada</span>
                            </label>
                            <Datepicker v-model="scheduledDate" 
                                        @blur="onChangeDate"
                                        locale="es"
                                        :start-time="startTime" 

                                        :format="formatScheduledDate" 
                                        minutes-increment="15"
                                        :is-24="false"/>
                        </div>
                        <div class="form-control basis-1/3 w-full">
                            <label class="label">
                                <span class="label-text">Fecha Realizada</span>
                            </label>
                            <Datepicker v-model="executedDate"
                                        @blur="onChangeDate"
                                        locale="es" 
                                        :start-time="startTime" 
                                        
                                        :format="formatExecutedDate" 
                                        minutes-increment="15" 
                                        :is-24="false"/>
                        </div>
                        <div class="flex flex-row basis-1/3 w-full space-x-4">
                            <div class="form-control basis-1/2 w-full">
                                <label class="label">
                                    <span class="label-text">Validez oferta</span>
                                </label>
                                <div class="input-group">
                                    <input  v-model="form.payday" 
                                            type="number"
                                            placeholder=""
                                            class="input input-sm input-bordered w-full"  />
                                    <span>días</span>
                                </div>
                            </div>
                            <div class="form-control basis-1/2 w-full">
                                <label class="label">
                                    <span class="label-text">Estado Presupuesto</span>
                                </label>
                                <select v-model="this.form.status" class="select select-sm select-bordered w-full">
                                    <option value="created">Creado</option>
                                    <option value="scheduled">Programado</option>
                                    <option value="terminated">Finalizado</option>
                                    <option value="cancelled">Cancelado</option>
                                </select>
                            </div>                        
                        </div>

                </div>
                <div class="flex space-x-4 mt-4">
                        <div class="form-control basis-1/3  w-full ">
                            <label class="label">
                                <span class="label-text">Referencia</span>
                            </label>
                            <input v-model="form.reference" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                        </div>
                        <div class="flex flex-row basis-1/3  w-full space-x-4">
                            <div class="form-control basis-1/2  w-full ">
                                <label class="label">
                                    <span class="label-text">Marca</span>
                                </label>
                                <input v-model="form.brand" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                            </div>
                            <div class="form-control basis-1/2 w-full">
                                <label class="label">
                                    <span class="label-text">Motor</span>
                                </label>
                                <input v-model="form.motor" type="text" placeholder="" class="input input-sm input-bordered w-full"  />
                            </div>                        
                        </div>

                        <div class="form-control basis-1/3 flex flex-row space-x-4">
                            <div class="form-control basis-1/3 w-full">
                                <label class="label">
                                    <span class="label-text">Pago</span>
                                </label>
                                <select v-model="this.form.is_paid" class="select select-sm select-bordered w-full max-w-xs">
                                    <option value=0>NO</option>
                                    <option value=1>SI</option>
                                </select>
                            </div>
                            <div class="form-control basis-1/3 w-full">
                                <label class="label">
                                    <span class="label-text">Moneda</span>
                                </label>
                                <select v-model="this.form.currency"
                                        @change="onChangeCurrency"
                                        class="select select-sm select-bordered w-full max-w-xs">
                                    <option value="PEN">S/.</option>
                                    <option value="USD">US$</option>
                                </select>
                            </div>
                            <div class="form-control basis-1/3 w-full">
                                <label class="label">
                                    <span class="label-text">Factor</span>
                                </label>
                                <input v-model="this.factor2" 
                                        type="number"
                                        @input="onChangeFactor2()"
                                        min=0
                                        step=0.05
                                        class="input input-sm input-bordered w-full" 
                                />
                            </div>
                        </div>

                </div>
                <div class="flex flex-col w-full border-opacity-50 my-6">
                    <div class="grid h-12 card bg-base-300 rounded-box place-items-center">SERVICIOS</div>
                </div>
                <div class=" my-4">
                    <div class="w-full">
                        <div class="flex space-x-4">
                            <span>&nbsp;</span>
                            <span class="basis-1/12">Código</span>
                            <span class="basis-1/12">Grupo</span>
                            <span class="basis-4/12">Descripción</span>
                            <span class="basis-2/12">Medida</span>
                            <span class="basis-1/12">Cantidad</span>
                            <span class="basis-1/12">Precio</span>
                            <span class="basis-1/12">Parcial</span>
                            <span class="basis-1/12"></span>
                        </div>
                        <div v-for="(service,index) in quoteServices"
                            :key="service.service_id"
                            class="my-2"
                            >
                            <div class="flex flex-row hover space-x-4 place-items-center">
                                <div>{{index+1}}</div>
                                <div class="basis-1/12">
                                    <input v-model="service.code" 
                                            @input="onInputService(index)"
                                            @focus="activeindex=index;this.lastservice=service;onInputService(index)"
                                            @keydown.enter.prevent="onSelectedFirstService(index)"
                                            @keydown.tab.prevent="onSelectedFirstService(index)"
                                            type="text" placeholder=""
                                            class="input input-sm input-bordered text-xs w-full" 
                                    /></div>
                                <div class="basis-1/12">
                                    <input v-model="service.group_name"
                                            type="text" placeholder="" 
                                            class="input input-sm input-bordered text-xs w-full" 
                                            readonly
                                    />
                                </div>
                                <div class="basis-4/12">
                                    <input v-model="service.description"
                                            type="text" placeholder="" 
                                            class="input input-sm input-bordered text-xs w-full" 
                                            :readonly="!(service.unit_original_price===null || service.unit_original_price===0)"
                                    />
                                </div>
                                <div class="basis-2/12">
                                    <input  v-if="service.have_measures"
                                            v-model="service.measure"
                                            type="text" placeholder=""
                                            @input="updateMeasuerByService(service)"
                                            class="input input-sm input-bordered text-xs w-full"  />
                                    </div>
                                <div class="basis-1/12">
                                    <input v-if="service.is_qty" v-model="service.quantity"
                                            type="number"
                                            step=1
                                            min=1
                                            pattern="\d*"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                            placeholder=""
                                            @input="updateQuantityByService(service)"
                                            class="input input-sm input-bordered text-xs text-right w-full"
                                            
                                    /></div>
                                <div class="basis-1/12">
                                    <input v-model="service.unit_price"
                                            type="number"
                                            step=0.01
                                            placeholder=""
                                            @input="updateSubtotalByService(service)"
                                            class="input input-sm input-bordered text-xs text-right w-full" 
                                    /></div>
                                <div class="basis-1/12">
                                    <input v-model="service.subtotal" 
                                            type="number" placeholder=""
                                            step="0.01"
                                            pattern="^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$"
                                            class="input input-sm input-bordered text-xs text-right w-full" readonly />
                                    </div>
                                <div class="basis-1/12 flex flex-row content-center">
                                    <button v-if="quoteServices.length>1"
                                        class="rounded-full p-0"
                                        @click.prevent="deleteService(index,service)">
                                        <XCircleIcon class="h-8 w-8 text-red-800 "/>
                                    </button>
                                    <button v-if="index==quoteServices.length-1" 
                                            class="rounded-full p-0"
                                            @click.prevent="addService">
                                            <PlusCircleIcon class="h-8 w-8 text-blue-800"/>        
                                    </button>
                                </div>
                            </div>
                            <div v-if="index===activeindex && searchingservice" class="flex flex-row hover space-x-4">
                                <div  class="basis-1/2">
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
                </div>
                <div class="flex flex-row">
                    <div class="flex flex-col w-3/4">
                        <div class="flex flex-row h-12 card bg-base-300 rounded-box place-items-center justify-center space-x-4">
                            <span>REPUESTOS</span>
                            <button v-if="quoteParts.length==0"
                                            class="rounded-full p-0"
                                            @click.prevent="addPart">
                                            <PlusCircleIcon class="h-8 w-8 text-blue-800"/>
                            </button>
                        </div>
                        <div class="p-3 w-full">
                            <div v-if="quoteParts.length>0" class="flex space-x-4">
                                <span>&nbsp;</span>
                                <span class="basis-5/12">Descripción</span>
                                <span class="basis-3/12">Medida</span>
                                <span class="basis-2/12">Cantidad</span>
                                <span class="basis-2/12"></span>
                            </div>
                            <div v-for="(part,index) in quoteParts"
                                :key="part.part_id"
                                class="my-2"
                                >
                                <div class="flex flex-row hover space-x-4">
                                    <div>{{index+1}}</div>
                                    <div class="basis-5/12">
                                        <input v-model="part.description"
                                            @input="onInputPart(index)"
                                            @focus="activeindexpart=index;this.lastpart=part;onInputPart(index)"
                                            @keydown.enter.prevent="onSelectedFirstPart(index)"
                                            @keydown.tab.prevent="onSelectedFirstPart(index)" 
                                            type="text" placeholder="" 
                                            class="input input-sm input-bordered text-xs w-full" 
                                        />
                                        <div v-if="index===activeindexpart && searchingpart" class="max-w-6xl w-full ">
                                            <ul class="menu bg-base-100 z-0 relative block w-full my-2">
                                                <li v-for="p in parts"
                                                    :key="p.id"
                                                    @click.prevent="onSelectedPart(p,index);"
                                                    class="p-2 first:bg-base-200 hover:bg-base-200"
                                                >
                                                    {{ p.description }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="basis-3/12">
                                        <input v-model="part.measure" 
                                                :ref="'measure_part_'+index" 
                                                :id="'measure_part_'+index" 
                                                type="text" 
                                                placeholder=""
                                                class="input input-sm input-bordered text-xs w-full"  />
                                        </div>
                                    <div class="basis-2/12">
                                        <input v-model="part.quantity"
                                                type="number"
                                                step=1
                                                min=1
                                                pattern="\d*"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                                placeholder=""
                                                
                                                class="input input-sm input-bordered text-xs text-right w-full"
                                                
                                    /></div>
                                    <div class="basis-2/12 flex flex-row content-center">
                                        <button class="rounded-full p-0"
                                                @click.prevent="deletePart(index)">
                                                <XCircleIcon class="h-8 w-8 text-red-800 "/>
                                        </button>
                                        <button v-if="index==quoteParts.length-1"
                                                class="rounded-full p-0"
                                                @click.prevent="addPart">
                                                <PlusCircleIcon class="h-8 w-8 text-blue-800"/>
                                        </button>
                                    </div>

                                </div>
                                <!-- <div v-if="index===activepartindex" class="max-w-6xl w-full ">
                                    <ul class="menu bg-base-100 z-0 relative block w-full my-2">
                                        <li v-for="srv in services"
                                            :key="srv.id" 
                                            @click="onSelectedService(srv,index)"
                                            class="p-2 first:bg-base-200 hover:bg-base-200"
                                        >
                                            {{ srv.label }}
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-1/4 border-opacity-50 m-6 w-full">
                        <div class="form-control mb-4 w-full">
                            <label class="input-group input-group-md">
                                <span class="w-2/3">Subtotal</span>
                                <span class="w-1/4">{{ symbol }}</span>
                                <input v-model="this.form.subtotal" type="number" placeholder="" class="input input-bordered input-md text-right w-full" readonly />
                            </label>
                        </div>
                        <div class="form-control mb-4 w-full">
                            <label class="input-group input-group-md">
                                <span class="w-2/3">IGV</span>
                                <span class="w-1/4">{{ symbol }}</span>
                                <input v-model="this.form.igv" 
                                        type="number" placeholder="" 
                                        class="input input-bordered border-l-0 input-md text-right w-full" readonly />
                            </label>
                        </div>
                        <div class="form-control mb-4 w-full">
                            <label class="input-group input-group-md">
                                <span class="w-2/3">Total</span>
                                <span class="w-1/4">{{ symbol }}</span>
                                <input  v-model="this.form.total" 
                                        type="number" placeholder=""
                                        class="input input-bordered input-md text-right w-full" readonly />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row">
                    <div class="flex flex-col w-full ">
                        <div class="border-opacity-50 mt-6">
                            <div class="flex flex-row h-12 card bg-base-300 rounded-box place-items-center justify-center space-x-4">
                                <span>NOTAS</span>
                                <button v-if="quoteNotes.length==0"
                                            class="rounded-full p-0"
                                            @click.prevent="addNote">
                                            <PlusCircleIcon class="h-8 w-8 text-blue-800"/>
                                </button>
                            </div>
                        </div>
                        <div v-for="(note,index) in quoteNotes"
                                :key="index"
                                class="my-2"
                                >
                                <div class="flex flex-row hover space-x-4 place-items-center">
                                    <div>{{index+1}}</div>
                                    <input v-model="note.description"
                                            type="text" placeholder="" 
                                            class="input input-sm input-bordered w-full" 
                                        />
                                    <div class="basis-1/12 flex flex-row content-center">
                                        <button class="rounded-full p-0"
                                                @click.prevent="deleteNote(index)">
                                                <XCircleIcon class="h-8 w-8 text-red-800 "/>
                                        </button>
                                        <button v-if="index==quoteNotes.length-1"
                                                class="rounded-full p-0"
                                                @click.prevent="addNote">
                                                <PlusCircleIcon class="h-8 w-8 text-blue-800"/>
                                        </button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col xl:flex-row xl:max-w-4xl justify-between w-full mx-auto mt-12">
                    <!-- <button v-if="this.dataquote!==undefined"
                        type="submit" class="btn btn-xl bg-indigo-700 hover:bg-indigo-900 xl:max-w-sm w-full mx-auto text-xl">
                        <DocumentIcon class="w-6 h-6"></DocumentIcon>
                        <span class="ml-2">Guardar y Abrir PDF</span>
                    </button> -->
                    <button type="submit" class="btn btn-xl bg-indigo-700 hover:bg-indigo-900 xl:max-w-sm w-full mx-auto text-xl">
                        <InboxIcon class="w-6 h-6"></InboxIcon>
                        <span class="ml-2">Guardar</span>
                    </button>
                </div>
                </form>
            </div>            
        </div>
        <jet-modal :show="showmodal" :closeable="false" @close="showmodal = null" maxWidth="sm">
            <div class="flex flex-row p-12">
                <!-- <a v-if="this.dataquote!==undefined"
                    :href="route('quotes.pdf',[this.dataquote.external_id])"
                    target="_blank"
                    class="xl:max-w-sm mx-auto text-xl flex flex-col align-middle items-center">
                        <DocumentIcon class="w-12 h-12 fill-indigo-700 hover:fill-indigo-800"></DocumentIcon>
                        <div class="ml-2 text-indigo-700 hover:text-indigo-800">Abrir PDF</div>
                </a> -->
                <button v-if="this.dataquote!==undefined"
                    @click.prevent="onClickPDF"
                    class="xl:max-w-sm mx-auto text-xl flex flex-col align-middle items-center">
                        <DocumentIcon class="w-12 h-12 fill-indigo-700 hover:fill-indigo-800"></DocumentIcon>
                        <div class="ml-2 text-indigo-700 hover:text-indigo-800">Abrir PDF</div>
                </button>
            </div>
            <div class="pb-6 text-center">
                <button @click.prevent="onClickClose"
                        class="btn btn-sm ">
                    Cerrar
                </button>
            </div>

        </jet-modal>
    </AppLayout>
</template>


<script>
    import { onMounted, ref } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetLabel from "@/Components/InputLabel.vue";
    import JetInput from "@/Components/Input.vue";
    import JetInputError from "@/Components/InputError.vue";
    import JetModal from '@/Components/Modal.vue';
    import axios from 'axios';
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    import { XCircleIcon,PlusCircleIcon,InboxIcon,DocumentIcon,ArrowSmallLeftIcon,MagnifyingGlassIcon } from '@heroicons/vue/24/solid'
    /*import VueMultiselect from 'vue-multiselect';
    import Multiselect from '@vueform/multiselect'
    import {throttle} from "lodash";*/

    export default {
        components: {
            AppLayout,
            JetLabel,
            JetInput,
            JetInputError,
            JetModal,
            axios,
            Datepicker,
            ref,
            XCircleIcon,
            PlusCircleIcon,
            InboxIcon,
            ArrowSmallLeftIcon,
            DocumentIcon,
            MagnifyingGlassIcon,
        },
        setup() {
            //const scheduledDate = ref(new Date().setHours(8,0,0));
            const scheduledDate = ref();
            const executedDate = ref();
            const startTime = ref({ hours: 8, minutes: 0 });
            
            const formatScheduledDate = (scheduledDate) => {
                const day = ("0" + scheduledDate.getDate()).slice(-2);
                const month =  ("0" + (scheduledDate.getMonth() + 1)).slice(-2);
                const year = scheduledDate.getFullYear();
                const hour = scheduledDate.getHours();
                const minutes = ("0" + scheduledDate.getMinutes()).slice(-2);
                const hours = ("0" + (hour>12 ? hour-12 : hour)).slice(-2);
                const med = hour>=12 ? 'PM' : 'AM';
                return `${day}/${month}/${year} ${hours}:${minutes} ${med}`;
            }

            const formatExecutedDate = (executedDate) => {
                const day = ("0" + executedDate.getDate()).slice(-2);
                const month =  ("0" + (executedDate.getMonth() + 1)).slice(-2);
                const year = executedDate.getFullYear();
                const hour = executedDate.getHours();
                const minutes = ("0" + executedDate.getMinutes()).slice(-2);
                const hours = ("0" + (hour>12 ? hour-12 : hour)).slice(-2);
                const med = hour>=12 ? 'PM' : 'AM';
                return `${day}/${month}/${year} ${hours}:${minutes} ${med}`;
            }

            return {
                scheduledDate,
                executedDate,
                formatScheduledDate,
                formatExecutedDate,
                startTime,
                //quote,
            }
        },
        mounted(){
            //console.log(this.scheduledDate);
            this.form.payday = this.default_payday;
            if(this.dataquote!==undefined){
                this.factor2 = this.dataquote.factor2;
                this.quoteServices = this.dataquote.services;
                this.quoteParts = this.dataquote.parts;
                this.quoteNotes = this.dataquote.notes;
                this.quoteServices.forEach((element) => {
                    this.quoteservicesids.push(element.service_id);
                })
                this.quoteParts.forEach((element) => {
                    this.quotepartsids.push(element.part_id);
                })
                this.splist = this.dataquote.details;
                if(this.dataquote.scheduled_date!==null) this.scheduledDate = new Date(this.dataquote.scheduled_date);
                if(this.dataquote.executed_date!==null) this.executedDate = new Date(this.dataquote.executed_date);
                this.form.name = this.dataquote.name;
                this.form.customer_id = this.dataquote.customer_id;
                this.form.document_type = this.dataquote.document_type;
                this.form.document_number = this.dataquote.document_number;
                this.form.name = this.dataquote.name;
                this.form.address = this.dataquote.address;
                this.form.reference = this.dataquote.reference;
                this.form.phone = this.dataquote.phone;
                this.form.email = this.dataquote.email;
                this.form.contact = this.dataquote.contact;
                this.form.brand = this.dataquote.brand;
                this.form.motor = this.dataquote.motor;
                this.form.currency = this.dataquote.currency;
                this.form.factor2 = this.factor2;
                this.form.services = this.quoteServices;
                this.form.parts = this.quoteParts;
                this.form.notes = this.quoteNotes;
                this.form.details = this.splist;
                this.form.subtotal =  this.dataquote.subtotal;
                this.form.igv = this.dataquote.igv;
                this.form.total = this.dataquote.total;
                this.form.status = this.dataquote.status;                
                this.form.is_paid = this.dataquote.is_paid;
                this.form.scheduled_date = this.dataquote.scheduled_date;
                this.form.executed_date = this.dataquote.executed_date;
                this.form.payday = this.dataquote.payday;
                this.onChangeCurrency();
                this.method= 'put';
                this.action= route('quotes.update',[this.dataquote.id]);
            }
            console.log(this.form.payday);
        },
        data() {
            return{
                method: 'post',
                action: route('quotes.store'),
                selectedCustomer: undefined,
                searchTermCustomer:'',
                selectedService: undefined,
                selectedPart: undefined,
                searchingservice:false,
                searchingpart:false,
                bp:false,
                activeindex:0,
                activeindexpart:0,
                factor2:1,
                quoteservicesids:[],
                quotepartsids:[],
                lastservice:[],
                lastpart:[],
                showmodal:null,
                er:1,
                symbol:'S/.',
                customers: {
                    type: Array,
                    default: () => []
                },
                services: {
                    type: Array,
                    default: () => []
                },
                parts: {
                    type: Array,
                    default: () => []
                },
                quoteServices:[
                    {
                        service_id: null,
                        code:'',
                        group_name:'',
                        description: '',
                        measure: null,
                        quantity: null,
                        unit_original_price: null,
                        unit_price: null,
                        subtotal: null,
                        have_measures: false,
                        have_parts: false,
                        is_qty: true,
                    }
                ],
                splist:[],
                quoteParts:[],
                quoteNotes:[],
                form: this.$inertia.form({
                    customer_id: null,
                    document_type: 'ruc',
                    document_number: null,
                    name: null,
                    address: null,
                    phone: null,
                    email: null,
                    reference:null,
                    brand:null,
                    motor:null,
                    contact: null,
                    factor2: null,
                    payday: null,
                    currency: 'PEN',
                    services: [],
                    parts: [],
                    notes:[],
                    details:[],
                    subtotal: 0,
                    igv: 0,
                    total: 0,
                    status: 'created',
                    is_paid: 0,
                    scheduled_date: null,
                    executed_date: null,
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
                this.searchingservice=true;
                //console.log(this.quoteservicesids);
                //if(this.quoteServices[index].code.length>0){
                    let term = this.quoteServices[index].code!=='' ? this.quoteServices[index].code: 'all';
                    let jsonquoteservicesids = JSON.stringify(this.quoteservicesids);
                    axios.get('/quotes/searchservices/'+ term +'/'+jsonquoteservicesids).then( response =>{
                        this.services = response.data;
                    }).catch( errors => {
                        this.errors = error.reponse.errors
                    });
                //}
            },
            async onInputPart(index){
                this.searchingpart=true;
                //console.log(this.quoteParts[index].description);
                //if(this.quoteParts[index].description.length>0){
                    let term = this.quoteParts[index].description!=='' ? this.quoteParts[index].description : 'all';
                    let jsonquotepartsids = JSON.stringify(this.quotepartsids);
                    axios.get('/quotes/searchparts/'+ term + '/' + jsonquotepartsids).then( response =>{
                        //console.log('response.data',response.data);
                        this.parts = response.data;
                    }).catch( errors => {
                        this.errors = error.reponse.errors
                    });
                //}
            },
            onSelectedCustomer(customer) {
                console.log(customer);
                this.selectedCustomer = customer;
                this.form.customer_id = customer.id;
                this.form.document_type = customer.document_type;
                this.form.document_number = customer.document_number;
                this.form.name = customer.name;
                this.form.address = customer.address;
                this.form.phone = customer.phone;
                this.form.email = customer.email;
                this.form.contact = customer.contact;
                this.form.payday = (customer.payday>0) ? customer.payday : this.default_payday;
                this.form.currency = customer.currency;
                this.factor2 = customer.factor2;
                this.form.factor2 = customer.factor2;
                this.onChangeCurrency();
                this.searchTermCustomer = customer.label;
                this.customers=[];
                //console.log(this.form);
            },
            onSelectedPart(part,index) {
                this.selectedPart = part;
                console.log('part',part);
                this.quoteParts[index] = {
                    part_id: part.id,
                    description: part.description,
                    //measure: part.measure,
                    measure: (parseInt(part.measure)>=0) ? null : part.measure,
                    measure_code_ref: (parseInt(part.measure)>=0) ? parseInt(part.measure) : null,
                    quantity: 1,
                }
                this.quotepartsids[index]=part.id;
                this.parts=[];
                this.selectedPart=undefined;
                // this.lastpart = [];
            },
            addService(){
                this.quoteServices.push({
                        service_id: null,
                        code:'',
                        group_name:'',
                        description: '',
                        measure: null,
                        quantity: null,
                        unit_original_price: null,
                        unit_price: null,
                        subtotal: null,
                        have_measures: false,
                        have_parts: false,
                        is_qty: false,
                });
            },
            addPart(){
                this.quoteParts.push({
                    part_id: null,
                    description: '',
                    measure: null,
                    measure_code_ref: null,
                    quantity: null
                });
            },
            addNote(){
                this.quoteNotes.push({
                    description: '',
                });
            },
            deleteService(index,service){
                var filtered = this.splist.filter(function(value){
                    return value.service_id !== service.service_id
                })
                var filtereddel = this.splist.filter(function(value){
                    return value.service_id === service.service_id
                })
                this.splist = filtered;
                var filteredqp = null;
                if(filtereddel.length>0){
                    filtereddel.forEach(element => {
                        filteredqp = this.quoteParts.filter(function(value){
                            return value.part_id === element.part_id
                        })
                        this.quoteParts = filteredqp;
                    })
                }
                this.quoteParts.forEach(element => {
                    if(element.measure_code_ref === service.code) element.measure = null;
                });

                //console.log(this.splist);
                this.quoteServices.splice(index,1);
                this.quoteservicesids.splice(index,1);
                //console.log(this.quoteservicesids);
                //this.updateQuoteParts();
                this.quoteServices.forEach((element) => {
                    this.updateSubtotalByService(element);
                });
            },
            deletePart(index){
                this.quoteParts.splice(index,1);
                this.quotepartsids.splice(index,1);
            },
            deleteNote(index){
                this.quoteNotes.splice(index,1);
            },
            onSelectedService(service,index) {
                this.selectedService = service;
                //console.log('service',service);
                this.quoteServices[index] = {
                    service_id: service.id,
                    code: service.code,
                    group_name: service.group.description,
                    description: service.description,
                    unit_original_price: service.unit_price,
                    unit_price: Number((service.unit_price * this.er * this.factor2).toFixed(2)),
                    have_measures: service.have_measures,
                    have_parts: service.have_parts,
                    is_qty: service.is_qty,
                    quantity: 1,
                    subtotal: Number((service.unit_price * this.er * this.factor2).toFixed(2)),
                }
                this.quoteservicesids[index]=service.id;
                if(this.lastservice !== []) this.deletePartsByService(this.lastservice.service_id)
                this.addPartsByService(service.id);
                //this.updateQuoteParts();
                // incio
                // this.splist.forEach((element) => {
                //     let part = {
                //         part_id: element.part_id,
                //         description: element.description,
                //         measure: null,
                //         quantity: element.quantity
                //     }
                //     var indexqp = this.quoteParts.findIndex( function(element){
                //         return element.part_id === part.part_id;
                //     });
                //     if(indexqp>=0){
                //         this.quoteParts[indexqp].quantity = this.quoteParts[indexqp].quantity + part.quantity;
                //     }
                //     else{
                //         this.quoteParts.push(part);
                //     }
                // });
                // fin
                this.updateTotals();
                this.services=[];
                this.lastservice = [];
            },

            onSelectedFirstCustomer() {
                //console.log(customer);
                if(this.customers.length>0){
                    this.selectedCustomer = this.customers[0];      
                    //console.log('selectedCustomer',this.selectedCustomer);
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
            onSelectedFirstService(index) {
                //console.log(customer);
                if(this.services.length>0){
                    this.selectedService = this.services[0];      
                    //console.log('selectedService',this.selectedService);
                    this.quoteServices[index] = {
                        service_id: this.selectedService.id,
                        code: this.selectedService.code,
                        group_name: this.selectedService.group.description,
                        description: this.selectedService.description,
                        unit_original_price: this.selectedService.unit_price,
                        unit_price: Number((this.selectedService.unit_price * this.er * this.factor2).toFixed(2)),
                        have_measures: this.selectedService.have_measures,
                        have_parts: this.selectedService.have_parts,
                        is_qty: this.selectedService.is_qty,
                        quantity: 1,
                        subtotal: Number((this.selectedService.unit_price * this.er * this.factor2).toFixed(2)),
                    }
                    if(this.lastservice !== []) this.deletePartsByService(this.lastservice.service_id)
                    this.addPartsByService(this.selectedService.id);
                    this.quoteservicesids[index]=this.selectedService.id;
                    //this.updateQuoteParts();
                    // incio
                    // this.splist.forEach((element) => {
                    //     let part = {
                    //         part_id: element.part_id,
                    //         description: element.description,
                    //         measure: null,
                    //         quantity: element.quantity
                    //     }
                    //     var indexqp = this.quoteParts.findIndex( function(element){
                    //         return element.part_id === part.part_id;
                    //     });
                    //     if(indexqp>=0){
                    //         this.quoteParts[indexqp].quantity = this.quoteParts[indexqp].quantity + part.quantity;
                    //     }
                    //     else{
                    //         this.quoteParts.push(part);
                    //     }
                    // });
                    // fin
                    this.updateTotals();          
                    //this.quoteservicesids.push(this.selectedService.id);
                    this.services=[];
                    this.lastservice = [];
                }
                else{
                    if(this.lastservice===[]){
                        this.quoteServices[index] = {
                            service_id: null,
                            code:'',
                            group_name: '',
                            description: '',
                            measure: null,
                            quantity: null,
                            unit_original_price: null,
                            unit_price: null,
                            subtotal: null,
                            have_measures: false,
                            have_parts: false,
                            is_qty: true,
                        }
                    }
                    else{
                        this.quoteServices[index] = this.lastservice;
                        this.lastservice=[];
                        this.addPartsByService(this.selectedService.id);
                        this.quoteservicesids[index]=this.selectedService.id;
                        this.updateQuoteParts();            
                        this.services=[];
                    }

                }
                //console.log(this.form);
            },
            onSelectedFirstPart(index) {
                //console.log('this.quoteParts.index',this.quoteParts[index]) ;
                //console.log('ev',ev);
                if(this.parts.length>0){
                    console.log('this.parts0',this.parts[0]);
                    this.selectedPart = this.parts[0];      
                    this.quoteParts[index] = {
                        part_id: this.parts[0].id,
                        description: this.parts[0].description,
                        //measure: this.parts[0].measure,
                        measure: (parseInt(this.parts[0].measure)>=0) ? null : this.parts[0].measure,
                        measure_code_ref: (parseInt(this.parts[0].measure)>=0) ? parseInt(this.parts[0].measure) : null,
                        quantity: 1,
                    }
                    this.quotepartsids[index]=this.parts[0].id;
                    this.parts=[];
                    this.lastpart = [];
                    this.$nextTick(() => {
                        this.$refs[`measure_part_${index}`][0].focus();
                    });
                    this.selectedPart=undefined;
                }
                else{
                    if(this.lastpart===[]){
                        this.quoteParts[index] = {
                            part_id: null,
                            description: '',
                            measure: null,
                            measure_code_ref: null,
                            quantity: null,
                        }
                    }
                    else{
                        this.quoteParts[index] = this.lastpart;
                        this.lastpart=[];
                        // this.quotepartsids[index]=this.selectedService.id;       
                        this.parts=[];
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
            },
            addPartsByService(service_id)
            {
                var filter = this.servicesparts.filter( obj => {
                    return obj.service_id === service_id;
                });
                filter.forEach( (element) => {
                    this.splist.push({
                        service_id: element.service_id,
                        part_id: element.part_id,
                        part_qty: element.part_qty,
                        quantity: element.part_qty,
                        //measure: element.measure,
                        //inherit_measure: element.inherit_measure,
                        //description: element.description
                    })
                    let part = {
                        part_id: element.part_id,
                        description: element.description,
                        measure: (parseInt(element.measure)>=0) ? null : element.measure,
                        measure_code_ref: (parseInt(element.measure)>=0) ? parseInt(element.measure) : null,
                        quantity: element.part_qty
                    }
                    var indexqp = this.quoteParts.findIndex( function(eqp){
                        return eqp.part_id === part.part_id;
                    });
                    if(indexqp>=0){
                        this.quoteParts[indexqp].quantity = this.quoteParts[indexqp].quantity + part.quantity;
                    }
                    else{
                        this.quoteParts.push(part);
                        if(!element.inherit_measure){
                            let indexsref = this.quoteServices.findIndex( function(esref){
                                return esref.code === part.measure_code_ref;
                            });
                            this.updateMeasuerByService(this.quoteServices[indexsref]);
                        }
                    }
                });
            },
            deletePartsByService(service_id){
                var filter = this.splist.filter( obj => {
                    return obj.service_id !== service_id;
                });
                this.splist = filter;
            },
            updatePartsByService(service){
                // var filter = this.splist.forEach( obj => {
                //    if(obj.service_id === service.service_id) 
                // });
                // this.splist = filter;
            },
            updateQuoteParts(){
                this.quoteParts=[];
                this.splist.forEach((element) => {
                    let part = {
                        part_id: element.part_id,
                        description: element.description,
                        measure: element.measure,
                        quantity: element.quantity
                    }
                    var indexqp = this.quoteParts.findIndex( function(element){
                        return element.part_id === part.part_id;
                    });
                    if(indexqp>=0){
                        this.quoteParts[indexqp].quantity = this.quoteParts[indexqp].quantity + part.quantity;
                    }
                    else{
                        this.quoteParts.push(part);
                    }
                });
                //console.log('this.quoteParts',this.quoteParts);
            },
            updateSubtotalByService(service){
                service.subtotal=Number((service.quantity*service.unit_price).toFixed(2));
                this.updateTotals();
            },
            updateQuantityByService(service){
                this.updateSubtotalByService(service);
                if(service.service_id !== null){
                    let filterparts = this.servicesparts.filter(element => {
                        return element.service_id === service.service_id;
                    });
                    if(filterparts.length>0){
                        filterparts.forEach((fp) =>{
                            let indexsp = this.splist.findIndex( function(element){
                                return element.service_id === fp.service_id && element.part_id === fp.part_id
                            });
                            let ini_quantity = this.splist[indexsp].quantity;
                            this.splist[indexsp].quantity = this.splist[indexsp].part_qty * service.quantity;

                            let indexqp = this.quoteParts.findIndex( function(element){
                                return element.part_id === fp.part_id;
                            });
                            if(indexqp>=0){
                                this.quoteParts[indexqp].quantity = this.quoteParts[indexqp].quantity - ini_quantity + this.splist[indexsp].quantity;
                            }
                        });

                        // this.splist.forEach((element) => {
                        //     let part = {
                        //         part_id: element.part_id,
                        //         description: element.description,
                        //         measure: element.measure,
                        //         quantity: element.quantity
                        //     }
                        //     var indexqp = this.quoteParts.findIndex( function(element){
                        //         return element.part_id === part.part_id;
                        //     });
                        //     if(indexqp>=0){
                        //         this.quoteParts[indexqp].quantity = this.quoteParts[indexqp].quantity + part.quantity;
                        //     }
                        //     else{
                        //         this.quoteParts.push(part);
                        //     }
                        // });
                    }
                }
                //this.updateQuoteParts();
                this.updateTotals();
            },
            updateMeasuerByService(service){
                this.quoteParts.forEach(element => {
                    if(element.measure_code_ref === service.code) element.measure = service.measure;
                });
                // if(service.service_id !== null){
                //     let filterparts = this.servicesparts.filter(element => {
                //         return ((parseInt(element.measure) === service.code && !element.inherit_measure) || (element.service_id === service.service_id &&  element.inherit_measure));
                //     });
                //     if(filterparts.length>0){
                //         filterparts.forEach((fp) =>{
                //             let indexsp = this.splist.findIndex( function(element){
                //                 return element.service_id === fp.service_id && element.part_id === fp.part_id;
                //             });
                //             //console.log('indexsp',indexsp);
                //             if(indexsp>=0){
                //                 this.splist[indexsp].measure =  service.measure;
                //                 let pid = this.splist[indexsp].part_id;
                //                 let indexqp = this.quoteParts.findIndex( function(eqp){
                //                     return eqp.part_id === pid;
                //                 });
                //                 this.quoteParts[indexqp].measure = service.measure;
                //             }
                //         });
                //     }
                // }
                //this.updateQuoteParts();
            },
            onChangeFactor2(){
                this.quoteServices.forEach((element) => {
                    if (element.unit_original_price != 0) element.unit_price =  Number((element.unit_original_price * this.er * this.factor2).toFixed(2)) ;
                    this.updateSubtotalByService(element);
                });
                this.updateTotals();
            },
            updateTotals(){
                this.form.subtotal = 0;
                this.quoteServices.forEach((element) => {
                    this.form.subtotal += element.subtotal;
                });
                this.form.subtotal = this.form.subtotal.toFixed(2);
                this.form.igv = (this.form.subtotal*0.18).toFixed(2);
                this.form.total = (this.form.subtotal*1.18).toFixed(2);
            },
            onChangeCurrency(){
                if(this.form.currency==='PEN'){
                    this.er=1;
                    this.symbol='S/.';
                }
                else{
                    this.er=this.exchange_rate;
                    this.symbol='US$';
                }
                
                this.onChangeFactor2();
            },
            onChangeDate(){
                if(this.scheduledDate !== undefined && this.scheduledDate !== null){
                    if(this.executedDate !== undefined && this.executedDate !== null) this.form.status='terminated';
                    else this.form.status='scheduled';
                }
                else{
                    if(this.executedDate !== undefined && this.executedDate !== null) this.form.status='terminated';
                    else this.form.status='created';
                }
            },
            onClickPDF(){
                window.open(route('quotes.pdf',[this.dataquote.external_id]), '_blank');
                if(this.method==='post') window.location.href = route('quotes.index');
            },
            onClickClose(){
                this.showmodal=null;
                if(this.method==='post') window.location.href = route('quotes.index');
            },
            searchRUC(){
                if(this.form.document_number!=''){
                    axios.get(`/search/ruc/${this.form.document_number}`).then( response =>{
                        console.log(response.data);
                        this.form.name = response.data.name;
                        this.form.address = response.data.address;
                    }).catch( errors => {
                        console.log(response.errors);
                    });
                }
            },
            submit() {
                var filteredServices = this.quoteServices.filter(function(value){
                    return value.service_id !== null
                })
                this.quoteServices = filteredServices;
                if(this.quoteServices.length>0){
                    this.form.factor2 = this.factor2;
                    this.form.services = this.quoteServices;
                    this.form.parts = this.quoteParts;
                    this.form.notes = this.quoteNotes;
                    this.form.details = this.splist;
                    if(this.scheduledDate !== undefined && this.scheduledDate !== null){
                        const scheduledday = ("0" + this.scheduledDate.getDate()).slice(-2);
                        const scheduledmonth = ("0" + (this.scheduledDate.getMonth() + 1)).slice(-2);
                        const scheduledyear = this.scheduledDate.getFullYear();
                        const scheduledhour = ("0" + this.scheduledDate.getHours()).slice(-2);
                        const scheduledminute = ("0" + this.scheduledDate.getMinutes()).slice(-2);
                        this.form.scheduled_date = `${scheduledyear}-${scheduledmonth}-${scheduledday} ${scheduledhour}:${scheduledminute}:00`;
                    }
                    else this.form.scheduled_date = null;
                    if(this.executedDate !== undefined && this.executedDate !== null){
                        const executedday = ("0" + this.executedDate.getDate()).slice(-2);
                        const executedmonth = ("0" + (this.executedDate.getMonth() + 1)).slice(-2);
                        const executedyear = this.executedDate.getFullYear();
                        const executedhour = ("0" + this.executedDate.getHours()).slice(-2);
                        const executedminute = ("0" + this.executedDate.getMinutes()).slice(-2);
                        this.form.executed_date = `${executedyear}-${executedmonth}-${executedday} ${executedhour}:${executedminute}:00`;
                    }
                    else this.form.executed_date = null;
                    //console.log(this.form);
                    this.form.submit( this.method, this.action, {
                        onFinish: () => {
                            //if(this.dataquote---undefined) this.dataquote = 
                            this.showmodal=true;
                            
                            //else window.open(route('quotes.pdf',[this.dataquote.external_id]), '_blank');
                            // this.acting = null;
                        }
                    });
                }
                else{
                    window.location.href = route('quotes.index');
                }
            },
        },
        props: {
            servicesparts: Object,
            dataquote: Object,
            exchange_rate: Number,
            exchange_sell: Number,
            default_payday: Number,
        },
    }
</script>