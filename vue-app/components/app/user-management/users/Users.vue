<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>

        <v-dialog
            v-model="show_form"
            grow
            persistent
            :width="$vuetify.breakpoint.mdAndUp?'20%':'100%'"
        >
            <user-form v-if="show_form" @closeForm="getData();show_form=false;selected = {}" :selected="selected"></user-form>
        </v-dialog>


        <v-toolbar dense flat dark color="primary">
            <v-toolbar-title class="subtitle-1 font-weight-bold" v-if="$vuetify.breakpoint.mdAndUp">List of user/s</v-toolbar-title>
            <v-spacer v-if="$vuetify.breakpoint.mdAndUp"></v-spacer>
            <v-btn  @click="selected ={}; show_form = true" class="text-none ml-2" small outlined>Add user</v-btn>
        </v-toolbar>
        <v-data-table
            :headers="fields"
            :items="items"
            :mobile-breakpoint="0"
            :loading="data_loading"
            loading-text="Please wait ....."
            :options.sync="pagination"
            :server-items-length="totalRecords"
            :items-per-page="5"
            @update:options="getData"
            :footer-props="{
                  showFirstLastPage: true,
                  'items-per-page-options': [5,10,15,20],
               }"
        >
            <template slot="item" slot-scope="props">
                <tr class="cursor-pointer">
                    <td @click="$emit('selected', props.item)" class="caption">
                        {{props.item.no + 1}}
                    </td>
                    <td class="caption">{{ props.item.full_name }}</td>
                    <td class="caption">{{ props.item.email }}</td>
                    <td class="caption">{{ props.item.phone }}</td>
                    <td class="caption">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn v-if="props.item.status !== 0 " v-on="on"
                                       @click="selected=props.item;confirmDelete()" icon>
                                    <v-icon small>mdi-close</v-icon>
                                </v-btn>
                            </template>
                            <span class="caption">Delete</span>
                        </v-tooltip>

                    </td>
                </tr>
            </template>
        </v-data-table>
    </div>
</template>
<script>
import UserForm from './UserForm.vue'
import table_mixin from "../../../common/mixins/table_mixin";
import appdetails from "../../../../helpers/appdetails";
export default {
    mixins:[table_mixin],
    components:{
        UserForm
    },
    methods: {
        getData() {
            this.data_loading = true;
            this.$axios.get('/api/user-management/users?page='
                +(this.pagination.page - 1)+'&perPage='+this.pagination.itemsPerPage+'&globalFilter='+this.globalFilter
            ).then((res) => {
                this.data_loading = false;
                this.items = res.data;
                this.items.map((item,key)=>{
                    item.no = key + ((this.pagination.page -1) *this.pagination.itemsPerPage);//this.pagination.page;
                });
                this.totalRecords = res.total;

            }, (err) => {
                this.data_loading = false;
            })
        },
        confirmDelete(){
            console.log("processing");
            this.$snotify.clear();
            this.$snotify.confirm('Are you sure you want to delete '+ this.selected.name+' role', 'Confirmation', {
                closeOnClick: false,
                pauseOnHover: true,
                buttons: [
                    {text: 'Yes', action: () => {
                            this.$snotify.clear();
                            this.$snotify.async('Please wait ....', 'Deleting ', () => new Promise((resolve, reject) => {
                                this.$axios.delete("/api/plants/"+this.selected.id).then((res) => {
                                    resolve({
                                        title: 'Success !!!',
                                        body: 'Deleted successifully',
                                        config: appdetails.snotifyconfig
                                    });

                                    this.getData();

                                }, (err) => {
                                    reject({
                                        title: 'Error !!!',
                                        body: 'An error occured during deletion,identified by ' + err.message,
                                        config: appdetails.snotifyconfig
                                    })
                                });
                            }));
                        }, bold: false},
                    {text: 'No', action: (toast) => this.$snotify.remove(toast.id)},
                ]
            });
        },
        getFields(){
            this.fields =   [
                {
                    text: '#',
                    align: 'left',
                    value: 'no',
                    sortable: false,
                    width: "1%"
                },
                {text: 'Name',sortable: false,value: 'name'},
              {text: 'Email',sortable: false,value: 'name'},
                {text: 'Phone',sortable: false,value: 'name'},
                { text: 'Action',sortable: false },
            ]
        }
    }
}
</script>

