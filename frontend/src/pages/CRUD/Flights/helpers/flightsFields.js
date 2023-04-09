const flightsFields = {
  id: { type: 'id', label: 'ID' },

  type: {
    type: 'string',
    label: 'FlightType',

    options: [
      { value: 'Approach', label: 'Approach' },

      { value: 'Hold', label: 'Hold' },

      { value: 'Landing', label: 'Landing' },

      { value: 'Daylanding(Full-stop)', label: 'Daylanding(Full-stop)' },

      { value: 'Night', label: 'Night' },

      { value: 'X-C', label: 'X-C' },

      { value: 'NightSimulatedInstrument', label: 'NightSimulatedInstrument' },

      { value: 'IMC', label: 'IMC' },

      { value: 'GroundSimulator', label: 'GroundSimulator' },
    ],
  },

  date: { type: 'datetime', label: 'Date' },

  duration: { type: 'decimal', label: 'Duration' },

  aircraft: { type: 'relation_one', label: 'Aircraft' },

  comments: { type: 'string', label: 'Comments' },
};

export default flightsFields;
