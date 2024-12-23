UPDATE tariffs
SET name        = :name,
    description = :description,
    price       = :price,
    expires_at  = :expires_at,
    created_at  = :created_at,
    speed       = :speed,
    logo        = :logo
WHERE id = :id