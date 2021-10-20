import {capitalizeFirstLetter} from '../utilities/functions.js'

export default {
  getResources(state) {
    let resources = [];
    state.jobs.forEach((item) => {
      resources.push({
        name: capitalizeFirstLetter(item.name),
        id: item.name
      })
    });

    return resources;
  },
  getColors(state) {
    return state.colors;
  }
}
