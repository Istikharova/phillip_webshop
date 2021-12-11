//Animation mit SrollReveal für navigation h1,h2,h4 und text

ScrollReveal().reveal('.navbar .container',{
    duration: 2000,
    origin:'bottom',
    distance:'10px',
    
});

ScrollReveal().reveal('h1',{
    duration: 1500,
    delay:500,
    origin:'top',
    distance:'10px',
    reset: true,
    useDelay: 'once'
});

ScrollReveal().reveal('#steinfiguren p',{
    duration: 2500,
    delay:1000,
    origin:'left',
    distance:'500px',
    reset: true,
    useDelay: 'once'
});

ScrollReveal().reveal('h2',{
    duration: 2000,
    origin:'top',
    distance:'10px',
    viewFactor:0.5,
    reset: true,
    useDelay: 'once'
});

ScrollReveal().reveal('h4',{
    duration: 2000,
    origin:'top',
    distance:'10px',
    viewFactor:0.5,
    reset: true,
    useDelay: 'once'
});


