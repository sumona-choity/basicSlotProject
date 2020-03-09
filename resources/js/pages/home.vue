<template>
<div class="container">
    <div class="row justify-content-between" v-if="isAdd">
            <div class="col-md-6">
                <div class="designation">
                    <Button @click="add_modal = true" type="info">Add a slot</Button> 
                </div>
            </div>
        </div>
    <div class="_day_sec">
        <!-- <ul class="_day_sec_ul">
            <li @click="available =! available" :class="{_day_active:available}">Friday</li>
            <li>Saturday </li>
            <li>Sunday </li>
            <li>Monday </li>
            <li>Tuesday </li>
            <li>Wednesday </li>
            <li>Thursday </li>
        </ul> -->
        <ul class="_day_sec_ul"  >
            <template > 
                <li v-for="(day,index) in this.days" :key="index" >
                    <template v-if="available && index == editIndex"><Button :class="{_day_active:available}">{{day}}</Button></template>
                    <template v-else><Button @click="isEditOn(day,index)" >{{day}}</Button></template>
                </li>
            </template>
        </ul>
    </div>
    <div class="_time_sec">
        <ul class="_time_sec_ul"  >
            <li v-for="(Slot,index) in AssignSlots" :key="index" >
                <template v-if="Slot.isBooked == 1"><Button class="_time_active" >{{Slot.slot}} <span><i class="fas fa-times"></i></span></Button></template>
                <template v-else><Button @click="booking(Slot,index)">{{Slot.slot}} <span><i class="fas fa-times"></i></span></Button></template>
            </li>
            <!-- <li class="_time_active">12:00 AM <span><i class="fas fa-times"></i></span></li>
            <li>12:00 AM <span><i class="fas fa-times"></i></span></li>
            <li>12:00 AM <span><i class="fas fa-times"></i></span></li>
            <li>12:00 AM <span><i class="fas fa-times"></i></span></li>
            <li>12:00 AM <span><i class="fas fa-times"></i></span></li>
            <li>12:00 AM <span><i class="fas fa-times"></i></span></li>
            <li>12:00 AM <span><i class="fas fa-times"></i></span></li> -->
        </ul>
    </div>
    <Modal
            v-model="add_modal"
            title="Add a Slot"
            @on-ok="form_submmit"
            @on-cancel="add_modal = false">
            <div class="left_atten_card">
                <div class="pro_left_input"> 
                    <div class="_1st_input_pro">
                        <div class="left_name_pro">
                            <span class="input_title">Slot</span>
                        </div>
                        <div class="right_input_pro">
                            <Input v-model="slot" style="width: 100%" />
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
</div>

</template>
<script>
    export default {
        data () {
            return {
                AssignSlots:[],
                available:false,
                slot:'',
                isAdd: false,
                modal: false,
                add_modal: false,
                booked_data: {},
                active: false,
                editIndex: -1,
                ob:{},
                day_data:'',
                days:['Friday','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday']
            }
        },
        methods:{
            isEditOn(day,index){
            this.day_data = day
            this.active = true
            this.available =true
            this.editIndex = index
            this.isAdd = true
            this.viewSlots();
            },


            async form_submmit(){
                    this.ob.club_id = 8,
                    this.ob.dayName = this.day_data,
                    this.ob.slot = this.slot
                const res = await this.callApi('post','AssignSlot',this.ob)
                if(res.status == 201){
                    this.s(' Slot have been successfully Assigned!')
                    this.AssignSlots.push(res.data)
                    this.slot = ''
                }
                else{
                    this.swr()
                }
        },
            async press_book () {
                const res = await this.callApi('post', 'booked', this.booked_data)
                if (res.status === 200) {
                    this.AssignSlots[this.editIndex] = _.clone(this.booked_data)
                    this.s('Booked!')
                    this.booked_data = {}
                    this.editIndex = -1
                }else{
                    this.swr();
                }

            },
            async viewSlots(){
                const res = await this.callApi('get',`showSlot?day=${this.day_data}`)
                if(res.status == 200){
                    this.AssignSlots = res.data
                }
            },
            booking(item,index){
                this.booked_data = _.cloneDeep(item)
                this.booked_data.isBooked = 1
                this.editIndex = index
                this.press_book();
            },  
    },
    async created(){
        let [res] = await Promise.all([
                this.callApi('get',`showSlot?day=${this.day_data}`)]);
            if(res.status == 200){
                this.AssignSlots = res.data
            }
        }
    }
</script>
<style lang="scss" scoped>

._day_sec{
    margin-top: 20px;
}
._day_sec_ul {
    list-style: none;
    display: flex;
}
._day_sec_ul li {
    border: 2px solid #000;
    border-radius: 3px;
    padding: 2px 10px;
    margin-right: 15px;
    cursor: pointer;
}
._day_active {
    border: 2px solid #000;
    color: #fff;
    background-color: #000;
}

._time_sec{margin-top: 20px;}
._time_sec_ul{
      list-style: none;
    display: flex;
    flex-wrap: wrap;
}
._time_sec_ul li {
    border: 1px solid #8c8b8b;
    border-radius: 3px;
    padding: 0px 5px;
    margin-right: 15px;
    position: relative;
    font-size: 14px;
    text-transform: uppercase;
}
._time_sec_ul li span {
    position: absolute;
    top: -13px;
    right: -12px;
    border: 1px solid #000;
    border-radius: 50%;
    padding: 1px;
    width: 15px;
    height: 15px;
    font-size: 11px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    color: #000;
}
._time_sec_ul li:hover span{
    opacity: 1;
    visibility: visible;
}
._time_active {
    border: 1px solid red !important;
    color: #fff;
    background-color: red;
}

</style>
