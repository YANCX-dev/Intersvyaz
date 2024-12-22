SELECT id,
       name,
       description,
       price,
       created_at,
       expires_at,
       speed,
       logo
FROM tariffs
WHERE id = :id