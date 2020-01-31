// v = value of the field
export default {
  required: [ v => !!v || 'This field is required' ],
  text: [
    v => !!v || 'This field is required',
    v => (v && v.length < 255) || 'Name must be less than 255 characters',
  ],
  number: [
    v => !!v || 'This field is required',
    v => (v > 0) || 'Number must be higher than 0',
    v => (v < 10000) || 'Amount not allowed higher than 9999,-',
  ],
  email: [
    v => !!v || 'E-mail is required',
    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
  ],
  checkbox: [v => !!v || 'You must agree to continue!'],
  item: [v => !!v || 'Item is required'],
  items: [v => (v.length > 0) || 'Input is required'],
}
