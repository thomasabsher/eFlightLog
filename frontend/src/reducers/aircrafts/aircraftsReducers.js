import list from 'reducers/aircrafts/aircraftsListReducers';
import form from 'reducers/aircrafts/aircraftsFormReducers';
import { combineReducers } from 'redux';

export default combineReducers({
  list,
  form,
});
