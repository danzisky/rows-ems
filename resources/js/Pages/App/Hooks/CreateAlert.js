import AlertProps from "./AlertProps";

const CreateAlert = {
  error: function (message = 'uknown error') {
    AlertProps.props.mutate(true, 'error', message)
  },
  warning: function (message = 'uknown error warning') {
    AlertProps.props.mutate(true, 'warning', message)
  },
  success: function (message = 'success') {
    AlertProps.props.mutate(true, 'success', message)
  },
  info: function (message) {
    AlertProps.props.mutate(true, 'info', message)
  },
  keep: function () {
    AlertProps.props.keepOpen(true)
  }
}

export default CreateAlert;