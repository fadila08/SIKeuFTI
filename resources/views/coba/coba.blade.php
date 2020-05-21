<div>
  @foreach ($coba as $key => $value)
  {{$key}}
  <table>
    <thead>
      <th>
        nilai 1
      </th>
      <th>
        nilai 2
      </th>
    </thead>
    <tbody>
      @foreach ($value as $item)
          
     
      <tr>
        <td>
          {{Crypt::decryptString($item->debet_saldo)}}
        </td>
        <td>
          {{Crypt::decryptString($item->cred_saldo)}}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endforeach
</div>