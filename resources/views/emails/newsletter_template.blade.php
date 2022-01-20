<div style="max-width: 75%; text-align: center; padding: 20px 30px; border: 1px solid #000; margin: auto">
    
    {{-- LOGO --}}
    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="128">
    {{-- LOGO --}}

    <br><br>
    <hr><br>

    {{-- TREŚĆ MAILA --}}
    <div style="text-align: justify;">
        <h3>Lorem ipsum</h3>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero expedita soluta optio suscipit, iusto quod
        voluptas fuga minima sunt deleniti est natus rem delectus obcaecati praesentium accusamus, aliquam dolore
        aperiam!
        <br>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias doloremque dolorem expedita modi iste vel
        impedit voluptates magni corrupti dolor, eaque soluta dolore saepe. Suscipit voluptatibus amet soluta optio at.
        <br>
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde inventore explicabo aliquid voluptatum
        architecto! Itaque impedit eum quod nisi natus accusantium esse atque magni, consectetur tenetur pariatur quo
        asperiores. Quidem.
    </div>
    {{-- TREŚĆ MAILA --}}

    <br><br>
    <hr><br><br>
    <a href="{{ url('anuluj-subskrypcje/' . $userData['token']) }}" style="background: darkblue; 
                color: #fff; 
                padding: 10px 20px; 
                border-radius: 3px;
                margin-bottom: 20px;
                text-decoration: none;">
        Anuluj subskrypcje Newslettera
    </a>
</div>
