let table_mixin = {
    data:()=>({
        pagination: {},
        fields: [],
        items: [],
        totalRecords: 0,
        data_loading: false,
        selected: {},
        show_form: false,
        deleting:false,
        globalFilter:'',
        expanded:[],
        table_props:{
            loading_text:'loading .....',
            no_data_text:'No data found',
            no_result_text:'No results found',
        }
    }),
    watch:{
        globalFilter(){
            this.getData();
        }
    },
    mounted() {
        if(this.getFields !== undefined) {
            this.getFields();
        }
    },
    methods:{
        getAxiosMessage(err){
            return (err && err.message) ? err.message : "Unable to process your request";
        },
        expandRow(item){
            if (this.expanded.indexOf(item) !== -1){
                this.expanded = [];
                return;
            }
            this.expanded.push(item);

        }
    }
};

export default table_mixin;