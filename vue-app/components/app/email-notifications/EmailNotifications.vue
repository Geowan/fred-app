<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>

        <v-dialog
                v-model="userFormDialog"
                grow
                persistent
                :width="$vuetify.breakpoint.mdAndUp?'25%':'100%'"
        >
            <div v-if="userFormDialog">
                <email-notification-form @closeForm="getData();userFormDialog=false;selected = {}" :selected="selected"></email-notification-form>
            </div>
        </v-dialog>


        <v-toolbar dense flat dark color="primary">
            <v-toolbar-title class="subtitle-1 font-weight-bold" v-if="$vuetify.breakpoint.mdAndUp">List of email notifications</v-toolbar-title>
            <v-text-field v-model="globalFilter" class="ml-2" hide-details solo light outlined dense label="Search email"></v-text-field>
          <v-spacer v-if="$vuetify.breakpoint.mdAndUp"></v-spacer>
            <v-btn  @click="selected ={}; userFormDialog = true" class="text-none ml-2" small outlined>Add email</v-btn>
        </v-toolbar>
        <v-data-table
                :headers="fields"
                :items="items"
                :mobile-breakpoint="0"
                :loading="!data_loaded"
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
                <tr>
                    <td class="caption">
                        {{props.item.no + 1}}
                    </td>
                    <td class="caption">{{ props.item.email }}</td>
                    <td class="caption">{{ props.item.plant?props.item.plant.name:'' }}</td>


                    <td class="caption">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn v-if="props.item.status !== 0 " v-on="on" @click="selected=props.item;confirmDelete()" icon>
                                    <v-icon small>mdi-close</v-icon>
                                </v-btn>
                            </template>
                            <span class="caption">Delete account</span>
                        </v-tooltip>

                    </td>
                </tr>
            </template>
        </v-data-table>
    </div>
</template>
<script>
    import fields from './fields'
    import EmailNotificationForm from './EmailNotificationForm.vue'
    import appdetails from "../../../helpers/appdetails";


    export default {
      watch:{
        globalFilter(val){
          this.getData();
        }
      },
        data: () => ({
            fields: fields,
            items: [],
            globalFilter: '',
            pagination: {},
            data_loaded: false,
            totalRecords: 0,
            selected: {},
            showPasswordResetDialog: false,
            userFormDialog: false,
        }),
        components:{
          EmailNotificationForm
        },
        methods: {
            getData() {
                this.data_loaded = false;
                this.$axios.get('/api/email-notifications?page='
                    +(this.pagination.page - 1)+'&perPage='+this.pagination.itemsPerPage+'&globalFilter='+this.globalFilter
                ).then((res) => {
                    this.data_loaded = true;
                    this.items = res.data;
                    console.log("res is ", res);
                    if(!this.items){
                        return;
                    }

                    this.items.map((item,key)=>{
                        item.no = key + ((this.pagination.page -1) *this.pagination.itemsPerPage);//this.pagination.page;
                    });
                    this.totalRecords = res.total;


                }, (err) => {
                    this.data_loaded = true;
                })
            },
            confirmDelete(){
                this.$snotify.clear();
                this.$snotify.confirm('Are you sure you want to delete '+ this.selected.email+' account', 'Confirmation', {
                    closeOnClick: false,
                    pauseOnHover: true,
                    buttons: [
                        {text: 'Yes', action: () => this.attemptDelete(), bold: false},
                        {text: 'No', action: (toast) => this.$snotify.remove(toast.id)},
                    ]
                });
            },
            attemptDelete(){
                this.$snotify.clear();
                this.$snotify.async('Please wait ....', 'Deleting ', () => new Promise((resolve, reject) => {
                    this.$axios.delete("/api/email-notifications/"+this.selected.id).then((res) => {
                        if (!res.data) {
                            reject({
                                title: 'Error !!!',
                                body: 'Unable to delete the account',
                                config: appdetails.snotifyconfig
                            });
                            return;
                        }
                        resolve({
                            title: 'Success !!!',
                            body: 'Account successifully deleted',
                            config: appdetails.snotifyconfig
                        });

                        this.getData();

                    }, (err) => {
                        reject({
                            title: 'Error !!!',
                            body: err.data? err.data.message:"Unable to process the request",
                            config: appdetails.snotifyconfig
                        })
                    });
                }));
            }
        }
    }
</script>

