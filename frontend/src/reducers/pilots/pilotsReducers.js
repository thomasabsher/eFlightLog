import list from 'reducers/pilots/pilotsListReducers';
import form from 'reducers/pilots/pilotsFormReducers';
import { combineReducers } from 'redux';

export default combineReducers({
  list,
  form,
});
