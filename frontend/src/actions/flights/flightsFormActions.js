import axios from 'axios';
import Errors from 'components/FormItems/error/errors';
import { push } from 'connected-react-router';
import { doInit } from 'actions/auth';
import { showSnackbar } from '../../components/Snackbar';

const actions = {
  doNew: () => {
    return {
      type: 'FLIGHTS_FORM_RESET',
    };
  },

  doFind: (id) => async (dispatch) => {
    try {
      dispatch({
        type: 'FLIGHTS_FORM_FIND_STARTED',
      });

      axios.get(`/flights/${id}`).then((res) => {
        const record = res.data;

        dispatch({
          type: 'FLIGHTS_FORM_FIND_SUCCESS',
          payload: record,
        });
      });
    } catch (error) {
      Errors.handle(error);

      dispatch({
        type: 'FLIGHTS_FORM_FIND_ERROR',
      });

      dispatch(push('/admin/flights'));
    }
  },

  doCreate: (values) => async (dispatch) => {
    try {
      dispatch({
        type: 'FLIGHTS_FORM_CREATE_STARTED',
      });

      axios.post('/flights', { data: values }).then((res) => {
        dispatch({
          type: 'FLIGHTS_FORM_CREATE_SUCCESS',
        });
        showSnackbar({ type: 'success', message: 'Flights created' });
        dispatch(push('/admin/flights'));
      });
    } catch (error) {
      Errors.handle(error);

      dispatch({
        type: 'FLIGHTS_FORM_CREATE_ERROR',
      });
    }
  },

  doUpdate: (id, values, isProfile) => async (dispatch, getState) => {
    try {
      dispatch({
        type: 'FLIGHTS_FORM_UPDATE_STARTED',
      });

      await axios.put(`/flights/${id}`, { id, data: values });

      dispatch(doInit());

      dispatch({
        type: 'FLIGHTS_FORM_UPDATE_SUCCESS',
      });

      if (isProfile) {
        showSnackbar({ type: 'success', message: 'Profile updated' });
      } else {
        showSnackbar({ type: 'success', message: 'Flights updated' });
        dispatch(push('/admin/flights'));
      }
    } catch (error) {
      Errors.handle(error);

      dispatch({
        type: 'FLIGHTS_FORM_UPDATE_ERROR',
      });
    }
  },
};

export default actions;
