grecaptcha.ready(() => {
  grecaptcha.execute('6Le2E38fAAAAAD2vEEf-YETvKl1XeBpL2OkTuG2z', { action: 'signup' }).then(token => {
    document.querySelector('#recaptchaResponse').value = token;
  });
});