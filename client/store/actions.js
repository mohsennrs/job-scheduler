
const jobs_api = '/api/jobs';
const schedules_api = '/api/schedules';

export default {
  async fetchJobs(context) {
    var response = await this.$axios.$get(jobs_api)
    .then(response => {
      context.commit('setJobs', response.data);
    }) ;
  },
  async fetchSchedules(context, [start_date, end_date]) {
    await this.$axios.$get(schedules_api, {
      params: {
        start_date: start_date,
        end_date: end_date
      }
    })
    .then(response => {
      context.commit('setSchedules', response.data);
    });

  }
}
