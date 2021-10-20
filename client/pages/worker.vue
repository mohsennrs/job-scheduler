<template>
  <div class="container mt-5">
    <Scheduler v-on:time-range-selection="timeRangeSelection"/>
  </div>

</template>

<script>
import Scheduler from '../components/Scheduler.vue'
import {DayPilot} from 'daypilot-pro-vue'
export default {
  components: {
    Scheduler
  },
  data() {
    return {
      dp:[]
    }
  },
  middleware: 'auth',
  methods: {
    async timeRangeSelection(args) {
      this.dp = args.control;
      const modal = await DayPilot.Modal.form([
        {name: "Shift", id: "shift", options: [
          {name: "Morning", id : "morning"},
          {name: "Evening", id : "evening"}
        ]},
        {name: "Description", id: "description"}
      ]);
      this.dp.clearSelection();
      if (modal.canceled) { return; }

      this.createSchedule(args, modal.result);
      // this.dp.events.add({
      //   start: args.start,
      //   end: args.end,
      //   id: DayPilot.guid(),
      //   resource: args.resource,
      //   text: modal.result
      // });
    },
    createSchedule(args, results) {
      this.$axios.$post('/api/schedules/create', {
        'date' : args.start.value,
        'job' : args.resource,
        'shift' : results.shift,
        'description' : results.description,

      }). then(response => {
        this.dp.events.add({
          start: args.start,
          end: args.end,
          id: DayPilot.guid(),
          resource: args.resource,
          text: response.data.shift + '\n' + response.data.user.name,
          backColor: 'rgb(10 142 255)'
        });

        this.dp.message('Schedule created with blue color');

        this.$echo.channel('schedules.'+response.data.id)
        .listen('ScheduleEdited', (e) => {
          console.log(e)
        })
      })
    }

  },
  beforeDestroy () {
    this.$echo.leave('schedules')
  }


}
</script>
