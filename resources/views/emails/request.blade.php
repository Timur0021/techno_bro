<table cellpadding="10" cellspacing="0" border="0" style="margin: 0 auto; border-collapse: collapse; width: 100%; max-width: 600px; font-family: Arial, sans-serif; background-color: #f9f9f9; border: 1px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <thead>
    <tr style="background-color: #4CAF50; color: white;">
        <th colspan="2" style="padding: 15px; font-size: 18px; text-align: center;">
            📨 Ви отримали нову заявку №{{ $request->id }}
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="font-weight: bold; width: 30%; text-align: center;">👤 Ім'я:</td>
        <td style="text-align: center;">{{ $request->name }}</td>
    </tr>
    <tr style="background-color: #f1f1f1;">
        <td style="font-weight: bold; text-align: center;">📞 Телефон:</td>
        <td style="text-align: center;">{{ $request->phone }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; text-align: center;">💬 Повідомлення:</td>
        <td style="text-align: center;">{{ $request->message }}</td>
    </tr>
    <tr style="background-color: #f1f1f1;">
        <td style="font-weight: bold; text-align: center;">🕒 Дата створення:</td>
        <td style="text-align: center;">{{ $request->created_at->format('Y-m-d H:i') }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center; padding-top: 20px;">
            <a href="{{ $url . 'admin/requests' }}" style="display: inline-block; background-color: #4CAF50; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: bold;">
                🔗 Перейти в панель адміністратора
            </a>
        </td>
    </tr>
    </tbody>
</table>
