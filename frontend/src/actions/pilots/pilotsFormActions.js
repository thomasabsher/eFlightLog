import axios from 'axios';
import Errors from 'components/FormItems/error/errors';
import { push } from 'connected-react-router';
import { doInit } from 'actions/auth';
import { showSnackbar } from '../../components/Snackbar';

const actions = {
  doNew: () => {
    return {
      type: 'PILOTS_FORM_RESET',
    };
  },

  doFind: (id) => async (dispatch) => {
    try {
      dispatch({
        type: 'PILOTS_FORM_FIND_STARTED',
      });

      axios.get(`/pilots/${id}`).then((res) => {
        const record = res.data;

        dispatch({
          type: 'PILOTS_FORM_FIND_SUCCESS',
          payload: record,
        });
      });
    } catch (error) {
      Errors.handle(error);

      dispatch({
        type: 'PILOTS_FORM_FIND_ERROR',
      });

      dispatch(push('/admin/pilots'));
    }
  },

  doCreate: (values) => async (dispatch) => {
    try {
      dispatch({
        type: 'PILOTS_FORM_CREATE_STARTED',
      });

      axios.post('/pilots', { data: values }).then((res) => {
        dispatch({
          type: 'PILOTS_FORM_CREATE_SUCCESS',
        });
        showSnackbar({ type: 'success', message: 'Pilots created' });
        dispatch(push('/admin/pilots'));
      });
    } catch (error) {
      Errors.handle(error);

      dispatch({
        type: 'PILOTS_FORM_CREATE_ERROR',
      });
    }
  },

  doUpdate: (id, values, isProfile) => async (dispatch, getState) => {
    try {
      dispatch({
        type: 'PILOTS_FORM_UPDATE_STARTED',
      });

      await axios.put(`/pilots/${id}`, { id, data: values });

      dispatch(doInit());

      dispatch({
        type: 'PILOTS_FORM_UPDATE_SUCCESS',
      });

      if (isProfile) {
        showSnackbar({ type: 'success', message: 'Profile updated' });
      } else {
        showSnackbar({ type: 'success', message: 'Pilots updated' });
        dispatch(push('/admin/pilots'));
      }
    } catch (error) {
      Errors.handle(error);

      dispatch({
        type: 'PILOTS_FORM_UPDATE_ERROR',
      });
    }
  },
};

export default actions;
