<template>
  <div>
    <div class="d-flex justify-content-end m-2">
      <button class="btn btn-primary m-2" v-text="'<<'" @click="previous"></button>
      <button class="btn btn-primary m-2" @click="today">Today</button>
      <button class="btn btn-primary m-2" v-text="'>>'" @click="next"></button>
    </div>
    <DayPilotScheduler id="dp" :config="config" ref="scheduler" />
  </div>
</template>
<script>
import {DayPilot, DayPilotScheduler} from 'daypilot-pro-vue'
import {capitalizeFirstLetter} from '../utilities/functions.js'
export default {
  name: 'Scheduler',
  components: {
    DayPilotScheduler
  },
  data: function() {
    return {
      config: {
        timeHeaders: [{groupBy: "Month", format: "MMMM, yyyy" }, {groupBy: "Week" }, {groupBy: 'Day', format: "dddd d-MMM"}],
        scale: "Day",
        days: 7,
        startDate: DayPilot.Date.today().firstDayOfWeek(),
        cellWidthSpec : "Auto",
        onTimeRangeSelected: async (args) => {
          this.$emit('time-range-selection', args);
        },
        onEventClick: async (args) => {
          this.$emit('on-event-click', args);
        },
        onBeforeTimeHeaderRender : function(args) {
          if (args.header.level === 1) {
            args.header.html = "Week " + args.header.start.weekNumberISO();
          }
        },
        resources : [],
        events : []
      },
    }
  },
  computed: {

  },
  methods: {
    previous() {
      this.config.startDate = this.config.startDate.addDays(-7);
    },
    next() {
      this.config.startDate = this.config.startDate.addDays(+7);
    },
    today() {
      this.config.startDate = DayPilot.Date.today().firstDayOfWeek()
    },
    changeDate(date) {
      this.config.startDate = date.firstDayOfMonth();
      this.config.events.list = [/* ... */]; // provide event data for the new date range
    },
    async fetchJobs() {
      // this.$store.dispatch('fetchJobs');
      await this.$axios.$get('/api/jobs',)
      .then(response => {
        response.data.forEach(item => {
          this.config.resources.push({
            name: capitalizeFirstLetter(item.name),
            id: item.name
          })
        });
      });
    },
    async fetchEvents() {
      const start_date = this.config.startDate.value;
      const end_date = this.config.startDate.addDays(6).value;
      this.config.resources = [];

      await this.$axios.$get('/api/schedules', {
        params: {
          start_date: start_date,
          end_date: end_date
        }
      })
      .then(response => {
        response.data.forEach(item => {

          this.config.events.push({
            "start": DayPilot.Date(item.date),
            "end": DayPilot.Date(item.date),
            "id": item.id,
            "resource": item.job,
            "text": item.shift + '\n' + item.user.name,
            "backColor": this.getEventColor(item)
          })
          // this.config.events.push(item)
        });
      });

      // this.$store.dispatch('fetchSchedules', [start_date, end_date]);
      // this.setResource();
    },
    getEventColor(event) {
      let color = '';
      if(event.status == 'accepted') {
        return this.$store.state.colors.green
      }
      if(event.status == 'created') {
        return this.$store.state.colors.blue
      }
      if(event.status == 'rejected') {
        return this.$store.state.colors.red
      }
    }
  },
  async fetch() {
    this.fetchJobs();
    this.fetchEvents();
  }
}
</script>
