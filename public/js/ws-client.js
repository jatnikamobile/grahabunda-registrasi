window.AntrianWS = function(host, type, id, onmessage, onerror) {

  let ws, autoRegenerateSession;

  function init() {
    ws = new WebSocket(`ws://${host}/Broadcast`);

    ws.addEventListener('error', function(...params) {
      setTimeout(function() {
        init();
      }, 3000);

      if(typeof onerror === 'function') onerror(...params);
    });

    ws.addEventListener('message', function(ev) {
      let data = JSON.parse(ev.data);

      if(data.type == 'command' && data.command == 'refresh') {
        window.location.reload();
      }

      if(typeof onmessage === 'function') onmessage(data);
      console.log(data);
    });
    ws.addEventListener('open', ev => register());
  }

  function register() {
    send({command: 'register', type, id});
  }

  function send(data) {
    ws.send(JSON.stringify(data));
    if(typeof autoRegenerateSession !== 'undefined') {
      clearTimeout(autoRegenerateSession);
    }
    autoRegenerateSession = setTimeout(() => register(), 10 * 60 * 1000);
  }

  function broadcast(data, scope) {
    send({command: 'broadcast', data, scope});
  }

  return {
    init, broadcast, send
  };
};

// ===================================

/*
// init web shocket
let ws = new AntrianWS('{{ config('ws.host') }}', {{ config('ws.port') }}, 'loket', idLoket, function(data) {
    if(data.type == 'broadcast') {
      var {data, sender} = data;
      if(data.command == 'update') {
        if((sender.type == 'loket' || (sender.type == 'anjungan' && !antrian.id)) && data.idLoket == idLoket) {
          handleAntrianResponse(data.result);
        }
        if((sender.type == 'anjungan' || sender.type == 'loket') && data.idLoket == idLoket) {
          let res = data.result;
          $('#sisa-antrian').html(`(sisa antrian: ${res.sisa_antrian})`);
          updateStatusAntrian(res);
        }
      }
    }
  });
  ws.init();
  
  // send data web shocket
  function panggil(data) {
    if(!data) return;
    let [huruf, nomor] = data.nomor_antrian.split('-');
    let speech = `nomor antrian ${huruf} ${Number(nomor)} di loket {{ $loket->nomor_loket }}`;
    $.ajax({ method: 'put', url: '{{ route('pendaftaran.panggil-antrian', [$loket]) }}/' + data.id })
    .done(function(res) {
      handleAntrianResponse(res);
      if(ws) {
        ws.broadcast({command: 'speak', speech, parameters: {rate: 0.9, volume: 1}}, {
          speaker: 1,
        });
        ws.broadcast({command: 'update', idLoket, result: res}, { loket: 'all', display: 1 });
      };
    });
  }

  // catch data web shocket 
  let ws = new AntrianWS('{{ config('ws.host') }}', {{ config('ws.port') }}, 'speaker', 1, function(data) {
    if(data.type == 'broadcast') {
      var {data, sender} = data;
      if(data.command == 'speak') {
        speechArray.push(data);
        speakQueue();
      }
    }
  });
  ws.init();
*/