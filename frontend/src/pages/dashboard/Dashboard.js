import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { CircularProgress, Box, Grid } from '@mui/material';
import {
  useManagementDispatch,
  useManagementState,
} from '../../context/ManagementContext';
import InfoIcon from '@mui/icons-material/Info';
import axios from 'axios';
// styles
import useStyles from './styles';
// components
import Widget from '../../components/Widget/Widget';

const Dashboard = () => {
  let classes = useStyles();
  const managementDispatch = useManagementDispatch();
  const managementValue = useManagementState();

  const [users, setUsers] = useState(0);
  const [aircrafts, setAircrafts] = useState(0);
  const [flights, setFlights] = useState(0);
  const [pilots, setPilots] = useState(0);

  const [currentUser, setCurrentUser] = useState(null);

  async function loadData() {
    const fns = [setUsers, setAircrafts, setFlights, setPilots];

    const responseUsers = await axios.get(`/users/count`);
    const responseAircrafts = await axios.get(`/aircrafts/count`);
    const responseFlights = await axios.get(`/flights/count`);
    const responsePilots = await axios.get(`/pilots/count`);
    Promise.all([
      responseUsers,
      responseAircrafts,
      responseFlights,
      responsePilots,
    ])
      .then((res) => res.map((el) => el.data))
      .then((data) => data.forEach((el, i) => fns[i](el.count)));
  }

  useEffect(() => {
    setCurrentUser(managementValue.currentUser);
    loadData();
  }, [managementDispatch, managementValue]);

  if (!currentUser) {
    return (
      <Box
        display='flex'
        justifyContent='center'
        alignItems='center'
        minHeight='100vh'
      >
        <CircularProgress />
      </Box>
    );
  }

  return (
    <div>
      <h1 className='page-title'>
        Welcome, {currentUser.firstName}! <br />
        <small>
          <small>Your role is {currentUser.role}</small>
        </small>
      </h1>
      <Grid container alignItems='center' columns={12} spacing={3}>
        <Grid item xs={12} sm={6} lg={4} xl={3}>
          <Link to={'/admin/users'} style={{ textDecoration: 'none' }}>
            <Widget title={'Users'}>
              <div
                style={{
                  display: 'flex',
                  alignItems: 'center',
                }}
              >
                <InfoIcon color='primary' sx={{ mr: 1 }} />
                <p className={classes.widgetText}>
                  Users:{' '}
                  <span className={classes.widgetTextCount}>{users}</span>
                </p>
              </div>
            </Widget>
          </Link>
        </Grid>

        <Grid item xs={12} sm={6} lg={4} xl={3}>
          <Link to={'/admin/aircrafts'} style={{ textDecoration: 'none' }}>
            <Widget title={'Aircrafts'}>
              <div
                style={{
                  display: 'flex',
                  alignItems: 'center',
                }}
              >
                <InfoIcon color='primary' sx={{ mr: 1 }} />
                <p className={classes.widgetText}>
                  Aircrafts:{' '}
                  <span className={classes.widgetTextCount}>{aircrafts}</span>
                </p>
              </div>
            </Widget>
          </Link>
        </Grid>

        <Grid item xs={12} sm={6} lg={4} xl={3}>
          <Link to={'/admin/flights'} style={{ textDecoration: 'none' }}>
            <Widget title={'Flights'}>
              <div
                style={{
                  display: 'flex',
                  alignItems: 'center',
                }}
              >
                <InfoIcon color='primary' sx={{ mr: 1 }} />
                <p className={classes.widgetText}>
                  Flights:{' '}
                  <span className={classes.widgetTextCount}>{flights}</span>
                </p>
              </div>
            </Widget>
          </Link>
        </Grid>

        <Grid item xs={12} sm={6} lg={4} xl={3}>
          <Link to={'/admin/pilots'} style={{ textDecoration: 'none' }}>
            <Widget title={'Pilots'}>
              <div
                style={{
                  display: 'flex',
                  alignItems: 'center',
                }}
              >
                <InfoIcon color='primary' sx={{ mr: 1 }} />
                <p className={classes.widgetText}>
                  Pilots:{' '}
                  <span className={classes.widgetTextCount}>{pilots}</span>
                </p>
              </div>
            </Widget>
          </Link>
        </Grid>
      </Grid>
    </div>
  );
};

export default Dashboard;
