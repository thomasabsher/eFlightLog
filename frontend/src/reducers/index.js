import auth from 'reducers/auth';
import { combineReducers } from 'redux';
import { connectRouter } from 'connected-react-router';

import users from 'reducers/users/usersReducers';

import aircrafts from 'reducers/aircrafts/aircraftsReducers';

import flights from 'reducers/flights/flightsReducers';

import pilots from 'reducers/pilots/pilotsReducers';

export default (history) =>
  combineReducers({
    router: connectRouter(history),
    auth,

    users,

    aircrafts,

    flights,

    pilots,
  });
