<div style="max-width: 75%; text-align: left; padding: 20px 30px; border: 0px solid #000; margin: auto">
    {{-- TREŚĆ MAILA --}}
    <div style="text-align: left;">
        <h3>Hej</h3>
        W  sklepie Odziej się odświeżyliśmy to i owo. 👈<br>
        Zawsze było wygodnie, ale teraz jest naprawdę na propsie. 👌<br>
        Dzielimy się radością   5% i 10% rabatu czeka. 🚀<br>
        <br>
        Użyj przy zamówieniu kodu ______<br>
        <br>
        Wbijaj i Odziej się! 👉 <a href="https://www.odziejsie.pl">https://www.odziejsie.pl</a><br><br>
        <a href="https://www.odziejsie.pl"><img src="{{ asset('assets/img/odziejsie.jpeg') }}" alt="" width="640"></a><br><br>
        ➤ <a href="https://www.odziejsie.pl">https://www.odziejsie.pl</a>
        <br><br>
    </div>
    {{-- TREŚĆ MAILA --}}
    <br>
    <small>*Jeżeli chcesz wypisać się z naszego Newslettera wystarczy kliknąć poniższy przycisk.</small><br><br>
    <a href="{{ url('anuluj-subskrypcje/' . $userData['token']) }}" style="background: darkblue; 
                color: #fff; 
                padding: 10px 20px; 
                border-radius: 3px;
                margin-bottom: 20px;
                text-decoration: none;">
        Anuluj subskrypcje Newslettera
    </a>
</div>
