export default {
  setJobs(state, jobs) {
    state.jobs = [];
    jobs.forEach(item => {
      state.jobs.push(item)
    })
  },
  setSchedules(state, schedules) {
    state.schedules = [];
    state.schedules = schedules.slice();
  }
}
