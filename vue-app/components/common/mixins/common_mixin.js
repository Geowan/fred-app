import moment from "moment";
const common_mixin = {

    methods:{
        getRangeDate(startDate, endDate, type) {
            let fromDate = moment(startDate)
            let toDate = moment(endDate)
            let diff = toDate.diff(fromDate, type)
            let range = []
            for (let i = 0; i <= diff; i++) {
                 if (i === diff) {
                     range.push({
                        start: moment(startDate).add(i, type).utcOffset('+0300').startOf(type).format('YYYY-MM-DD HH:mm'),
                        end: moment(endDate).utcOffset('+0300').format('YYYY-MM-DD HH:mm'),
                        label:moment(startDate).add(i, type).utcOffset('+0300').format((type === 'hour')?"HH:mm":"DD-MMMM")
                    })
                } else {
                    range.push({
                        start: moment(startDate).add(i, type).utcOffset('+0300').startOf(type).format('YYYY-MM-DD HH:mm'),
                        end: moment(startDate).add(i, type).utcOffset('+0300').endOf(type).format('YYYY-MM-DD HH:mm'),
                        label:moment(startDate).add(i, type).utcOffset('+0300').format((type === 'hour')?"HH:mm":"DD-MMMM")
                    })
                }
            }
            return range
        },
    }


};
export default common_mixin;