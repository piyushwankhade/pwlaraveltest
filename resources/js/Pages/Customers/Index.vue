<template>
<Head title="Customers" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers
            </h2>
        </template>

        <div class="py-12">
             <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4 flex justify-between">
                            <Link class="px-6 py-2 mb-2 text-green-100 bg-green-500 rounded" :href="route('customers.create')">Create Customer</Link>

                            <select name="filterTerm" @change="filterMethod" v-model="filterTerm">
														  <option value="">Select ...</option>
														  <option value="birthday_this_week">Birthday this week</option>
														</select>
                            
                            <input type="text" @keyup="searchMethod" v-model="searchTerm" placeholder="Search.." class="border  rounded ">
                        </div>
                        

                    <div class="flex flex-col">
                      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="changeOrder('name')">Name</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="changeOrder('company')">Company</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="changeOrder('birthday')">Birth Date</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="changeOrder('last_interaction')">Last Interaction</th>
                                  <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                  </th>
                                </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                <tr  v-for="customer in customers.data" :key="customer.id">
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                      <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" :src="customer.photo" alt="">
                                      </div>
                                      <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ customer.first_name }} {{ customer.last_name }}</div>
                                      </div>
                                    </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ customer.company }}</div>
                                    <div class="text-sm text-gray-500"></div>
                                  </td>
                                  
                                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ customer.birth_date }}</td>
                                   <td class="px-6 py-4 whitespace-nowrap">
                                   	{{ customer.last_interaction_date }}
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">  {{customer.last_interaction_type }} </span>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link class="text-indigo-600 hover:text-indigo-900" :href="'customers/'+customer.id+'/edit'">Edit</Link>                                   
                                  </td>
                                </tr>

                                <!-- More people... -->
                              </tbody>
                            </table>

                            

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mt-6">
                        <Pagination :links="customers.links" />
                    </div>


                        
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>


<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Shared/Pagination';
import {Inertia} from "@inertiajs/inertia";

export default {
	name : 'Index',
	props: {
    customers: Object,
    search : String,
    filter : String,
    order : String,
    dir : String,
  },
  components: {
      BreezeAuthenticatedLayout,
      Head,
      Link,
      Pagination,
  },
  data () {
    return {
      searchTerm : this.search,
      filterTerm : this.filter,
      orderTerm : this.order,
      dirTerm : this.dir,
    };
  },
  methods: {
    getCustomers :  function() {
      Inertia.get('customers',{ 
        search : this.searchTerm, 
        filter : this.filterTerm,
        order : this.orderTerm,
        dir : this.dirTerm, 
      },{
          preserveScroll : true,
          preserveState : true,
          replace : true,
      });
    },
    changeOrder : function (val) {
      this.orderTerm = val;
      this.dirTerm = this.dirTerm === 'asc' ? 'desc' : 'asc';
      this.getCustomers();
    },
  	filterMethod : function() {
  		this.getCustomers();
  	},
    searchMethod : _.debounce (function() {
    	this.getCustomers();
    },500)
  },
};
</script>