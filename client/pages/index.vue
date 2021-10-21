<template>
  <div class="container mt-5">
    <Scheduler v-on:time-range-selection="timeRangeSelection" v-on:on-event-click="onEventClick"/>
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
  methods: {
    async timeRangeSelection(args) {
      if(!this.$auth.loggedIn || this.$auth.user.is_admin) {
        // this.adminSetup(args);
        return true;
      }
      this.workerSetup(args);

    },
    onEventClick (args) {
      if (!this.$auth.loggedIn || !this.$auth.user.is_admin) {
        return true;
      }
      this.adminSetup(args)

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
          id: response.data.id,
          resource: args.resource,
          text: response.data.shift + '\n' + response.data.user.name,
          backColor: 'rgb(10 142 255)'
        });

        this.dp.message('Schedule created with blue color');
        let vm = this;
        this.$echo.channel('schedule.edit.'+response.data.id)
        .listen('ScheduleUpdateEvent', (e) => {
          console.log(response.data.id);
          var color = e.schedule.status == 'accepted' ? this.$store.state.colors.green : this.$store.state.colors.red;
          var event = vm.dp.events.find(response.data.id);

          vm.dp.message('Schedule number ' + response.data.id + e.schedule.status);
          event.data.backColor = color;
        })
      })
    },
    editSchedule(args, results) {
      let vm = args;
      this.$axios.$post('/api/schedules/edit/' + args.e.id(), {
        'job_id' : args.e.id(),
        'status' : results.status,
        'description' : results.description,

      }).then(response => {
        var color = results.status == 'accepted' ? this.$store.state.colors.green : this.$store.state.colors.red;
        var event = this.dp.events.find(args.e.id());
        event.data.backColor = color;
      })
    },
    async workerSetup(args) {
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
    },
    async adminSetup(args) {
      this.dp = args.control;
      const modal = await DayPilot.Modal.form([
        {name: "Status", id: "status", options: [
          {name: "Accept", id : "accepted"},
          {name: "Reject", id : "rejected"}
        ]},
        {name: "Description", id: "description"}
      ]);
      this.dp.clearSelection();
      if (modal.canceled) { return; }

      this.editSchedule(args, modal.result);
    }

  },
  beforeDestroy () {
    this.$echo.leave('schedules')
  }


}
</script>
