import { reactive, watch } from 'vue'

const AlertProps = reactive({
  props: {
    alerts: [],
    open: false,
    type: 'info',
    message: '',
    mutateS(open, type = 'info', message = '') {
      this.type = type
      this.message = message
      this.open = open
    },
    mutate(open, type = 'info', message = '') {
      let alert = {}
      alert.type = type
      alert.message = message
      alert.open = open
      let index = this.alerts.push(alert)
      setTimeout(() => popAlert(index - 1), 5000)
    },
    keepOpen() {
      this.open = true
    }
  },
})

function popAlert(index) {
  try {
    if (Array.isArray(AlertProps.props?.alerts)) {
      if (AlertProps.props?.alerts?.length > 1) {
        if (AlertProps.props?.alerts?.reverse()?.pop(index)) {
          AlertProps.props?.alerts?.reverse()
        }
      } else {
        AlertProps.props.alerts = []
      }
    }
  } catch (error) {

  }
}

watch(AlertProps.props, async (newValue, oldValue) => {
  if (AlertProps.props.open == true) {
    setTimeout(() => (AlertProps.props.open = true), 2000) /* incase there's an unexpired timeout that closes the alert */
    setTimeout(() => (AlertProps.props.open = false), 5000)
  }
})

export default AlertProps