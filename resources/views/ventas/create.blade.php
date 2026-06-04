@extends('layouts.pos')

@section('title', 'Punto de Venta')

@section('content')
<div x-data="posSystem()" x-cloak style="flex:1; display:flex; overflow:hidden; height:100%;">

    <!-- ========== LADO IZQUIERDO: CATÁLOGO ========== -->
    <div style="flex:1; display:flex; flex-direction:column; overflow:hidden; background:#f8fafc;">

        <!-- Buscador -->
        <div style="padding:8px 12px; background:#fff; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; gap:10px; flex-shrink:0;">
            <div style="position:relative; flex:1;">
                <input type="text" x-model="search" placeholder="Buscar producto por nombre o código..."
                    style="width:100%; padding:7px 10px 7px 32px; background:#f1f5f9; border:1px solid #e2e8f0; font-size:12px; color:#1e293b; outline:none;"
                    @keydown.escape="search = ''">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px; position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <span style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">
                <span x-text="filteredProducts.length"></span> productos
            </span>
        </div>

        <!-- Grid de productos con SCROLL -->
        <div style="flex:1; overflow-y:auto; padding:8px;" class="pos-scrollbar">
            <template x-if="filteredProducts.length === 0">
                <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:#cbd5e1;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:36px;height:36px;margin-bottom:6px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <p style="font-size:11px;font-weight:700;text-transform:uppercase;">Sin resultados</p>
                </div>
            </template>

            <div class="pos-grid">
                <template x-for="product in filteredProducts" :key="product.id_producto">
                    <div class="pos-card"
                         :style="product.stock <= 0 ? 'opacity:0.35;pointer-events:none;' : ''"
                         @click="addToCart(product)">
                        <div class="pos-card-img">
                            <template x-if="product.imagen">
                                <img :src="'/storage/' + product.imagen" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                            </template>
                            <template x-if="!product.imagen">
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#e2e8f0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </template>
                            <span class="pos-badge"
                                  :style="product.stock <= 5 ? 'background:#ef4444;color:#fff;' : ''"
                                  x-text="product.stock"></span>
                        </div>
                        <div class="pos-card-info">
                            <div class="pos-card-name" x-text="product.nombre"></div>
                            <div class="pos-card-price" x-text="'S/ ' + parseFloat(product.precio_venta).toFixed(2)"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- ========== LADO DERECHO: CARRITO ========== -->
    <div style="width:340px; min-width:340px; background:#fff; border-left:1px solid #e2e8f0; display:flex; flex-direction:column; overflow:hidden;">

        <!-- Header carrito -->
        <div style="padding:8px 12px; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; background:#f8fafc;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;color:#6366f1;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span style="font-size:11px; font-weight:800; color:#334155; text-transform:uppercase; letter-spacing:0.08em;">Carrito</span>
                <span x-show="cart.length > 0" style="font-size:9px; font-weight:700; color:#6366f1; background:#eef2ff; padding:2px 6px;" x-text="getTotalItems() + ' items'"></span>
            </div>
            <button x-show="cart.length > 0" @click="clearCart()"
                style="font-size:9px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; background:none; border:none; cursor:pointer;"
                onmouseover="this.style.color='#ef4444';" onmouseout="this.style.color='#94a3b8';">
                Limpiar
            </button>
        </div>

        <!-- Cliente -->
        <div style="padding:8px 12px; border-bottom:1px solid #f1f5f9; flex-shrink:0;">
            <label style="font-size:9px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em; display:block; margin-bottom:4px;">Cliente</label>
            <select x-model="cliente_id" style="width:100%; padding:5px 8px; background:#f8fafc; border:1px solid #e2e8f0; font-size:11px; color:#475569; font-weight:500; outline:none;">
                <option value="">Mostrador (Sin cliente)</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                @endforeach
            </select>
        </div>

        <!-- Items del carrito con SCROLL -->
        <div style="flex:1; overflow-y:auto;" class="pos-scrollbar">
            <template x-if="cart.length === 0">
                <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:#cbd5e1; padding:20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin-bottom:8px;opacity:0.4;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <p style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em;">Carrito vacío</p>
                    <p style="font-size:10px; color:#cbd5e1; margin-top:4px;">Clic en un producto para agregar</p>
                </div>
            </template>

            <template x-for="(item, index) in cart" :key="item.id_producto">
                <div class="pos-cart-item">
                    <span style="font-size:9px; font-weight:700; color:#cbd5e1; width:14px; text-align:center; flex-shrink:0;" x-text="index + 1"></span>
                    <div style="flex:1; min-width:0;">
                        <div style="font-size:11px; font-weight:600; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" x-text="item.nombre"></div>
                        <div style="font-size:10px; color:#94a3b8;" x-text="'S/ ' + parseFloat(item.precio_venta).toFixed(2) + ' c/u'"></div>
                    </div>
                    <div style="display:flex; align-items:center; gap:1px; flex-shrink:0;">
                        <button @click="updateQty(index, -1)" class="pos-qty-btn" style="color:#ef4444;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:10px;height:10px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" /></svg>
                        </button>
                        <span style="width:28px; height:24px; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#1e293b; background:#f1f5f9; border:1px solid #e2e8f0;" x-text="item.qty"></span>
                        <button @click="updateQty(index, 1)" class="pos-qty-btn" style="color:#6366f1;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:10px;height:10px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                        </button>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:#1e293b; width:64px; text-align:right; flex-shrink:0;" x-text="'S/ ' + (item.precio_venta * item.qty).toFixed(2)"></span>
                    <button @click="removeFromCart(index)" class="pos-remove-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:10px;height:10px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </template>
        </div>

        <!-- Checkout: fijo abajo, nunca se mueve -->
        <div style="flex-shrink:0; border-top:2px solid #e2e8f0;">
            <!-- Totales -->
            <div style="padding:10px 12px; background:#f8fafc;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <span style="font-size:9px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em;">Subtotal</span>
                    <span style="font-size:11px; font-weight:600; color:#64748b;" x-text="'S/ ' + getTotal().toFixed(2)"></span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <span style="font-size:9px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em;">Items</span>
                    <span style="font-size:11px; font-weight:600; color:#64748b;" x-text="getTotalItems()"></span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:8px; border-top:1px solid #e2e8f0;">
                    <span style="font-size:12px; font-weight:900; color:#1e293b; text-transform:uppercase; letter-spacing:0.05em;">Total</span>
                    <span style="font-size:20px; font-weight:900; color:#1e293b; letter-spacing:-0.02em;" x-text="'S/ ' + getTotal().toFixed(2)"></span>
                </div>
            </div>

            <!-- Método de pago -->
            <div style="padding:8px 12px;">
                <label style="font-size:9px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em; display:block; margin-bottom:6px;">Método de pago</label>
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:6px;">
                    <button @click="metodo_pago = 'Efectivo'" class="pos-pago-btn" :class="metodo_pago === 'Efectivo' ? 'pos-pago-active' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        <span>Efectivo</span>
                    </button>
                    <button @click="metodo_pago = 'Tarjeta'" class="pos-pago-btn" :class="metodo_pago === 'Tarjeta' ? 'pos-pago-active' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        <span>Tarjeta</span>
                    </button>
                    <button @click="metodo_pago = 'Yape'" class="pos-pago-btn" :class="metodo_pago === 'Yape' ? 'pos-pago-active' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        <span>Yape</span>
                    </button>
                    <button @click="metodo_pago = 'Plin'" class="pos-pago-btn" :class="metodo_pago === 'Plin' ? 'pos-pago-active' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        <span>Plin</span>
                    </button>
                    <button @click="metodo_pago = 'Transferencia'" class="pos-pago-btn" :class="metodo_pago === 'Transferencia' ? 'pos-pago-active' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        <span>Transfer.</span>
                    </button>
                </div>
            </div>

            <!-- Botón cobrar -->
            <div style="padding:8px 12px 12px;">
                <button @click="showConfirm = true" :disabled="cart.length === 0"
                    class="pos-btn-cobrar"
                    :style="cart.length === 0 ? 'background:#e2e8f0;color:#94a3b8;cursor:not-allowed;' : ''">
                    <span style="display:flex; align-items:center; gap:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        COBRAR S/ <span x-text="getTotal().toFixed(2)"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- ========== DIALOG CONFIRMACIÓN ========== -->
    <template x-if="showConfirm">
        <div style="position:fixed; inset:0; z-index:200; display:flex; align-items:center; justify-content:center; padding:24px;">
            <!-- Overlay -->
            <div @click="!processing && !saleSuccess ? (showConfirm = false) : null" style="position:absolute; inset:0; background:rgba(15,23,42,0.65); backdrop-filter:blur(3px);"></div>

            <!-- Dialog -->
            <div class="pos-dialog">

                <!-- Estado: Confirmación -->
                <template x-if="!saleSuccess">
                    <div style="display:flex; flex-direction:column; max-height:75vh;">
                        <!-- Header -->
                        <div style="padding:20px 28px; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:32px; height:32px; background:#eef2ff; display:flex; align-items:center; justify-content:center; border-radius:8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;color:#6366f1;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                                </div>
                                <div>
                                    <div style="font-size:15px; font-weight:800; color:#1e293b; line-height:1.2;">Confirmar Venta</div>
                                    <div style="font-size:10px; color:#94a3b8; font-weight:500;">Revisa el detalle antes de procesar</div>
                                </div>
                            </div>
                            <button @click="showConfirm = false" :disabled="processing" class="pos-dialog-close">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <!-- Info cliente y pago -->
                        <div style="padding:16px 28px; background:#f8fafc; border-bottom:1px solid #f1f5f9; display:flex; gap:16px; flex-shrink:0;">
                            <div style="flex:1; background:#fff; border:1px solid #e2e8f0; padding:10px 14px; border-radius:6px;">
                                <div style="font-size:9px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:4px;">Cliente</div>
                                <div style="font-size:12px; font-weight:600; color:#1e293b;" x-text="getClienteName()"></div>
                            </div>
                            <div style="width:120px; background:#fff; border:1px solid #e2e8f0; padding:10px 14px; border-radius:6px;">
                                <div style="font-size:9px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:4px;">Pago</div>
                                <div style="font-size:12px; font-weight:600; color:#1e293b;" x-text="metodo_pago"></div>
                            </div>
                        </div>

                        <!-- Lista de items -->
                        <div style="flex:1; overflow-y:auto;" class="pos-scrollbar">
                            <div style="padding:12px 28px 6px;">
                                <div style="font-size:9px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em;">Detalle de productos</div>
                            </div>
                            <template x-for="(item, index) in cart" :key="item.id_producto">
                                <div style="display:flex; align-items:center; padding:10px 28px; gap:12px; border-bottom:1px solid #f8fafc;">
                                    <span style="font-size:10px; font-weight:700; color:#c7d2fe; background:#eef2ff; width:22px; height:22px; display:flex; align-items:center; justify-content:center; border-radius:4px; flex-shrink:0;" x-text="index + 1"></span>
                                    <div style="flex:1; min-width:0;">
                                        <div style="font-size:12px; font-weight:600; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" x-text="item.nombre"></div>
                                        <div style="font-size:10px; color:#94a3b8; margin-top:1px;" x-text="item.qty + ' x S/ ' + parseFloat(item.precio_venta).toFixed(2)"></div>
                                    </div>
                                    <span style="font-size:12px; font-weight:700; color:#1e293b; white-space:nowrap;" x-text="'S/ ' + (item.precio_venta * item.qty).toFixed(2)"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Total -->
                        <div style="padding:16px 28px; border-top:2px solid #e2e8f0; background:#f8fafc; flex-shrink:0;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                <span style="font-size:11px; font-weight:600; color:#94a3b8;">Items totales</span>
                                <span style="font-size:12px; font-weight:600; color:#64748b;" x-text="getTotalItems()"></span>
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:center; padding-top:10px; border-top:1px solid #e2e8f0;">
                                <span style="font-size:14px; font-weight:900; color:#1e293b; text-transform:uppercase; letter-spacing:0.05em;">Total a cobrar</span>
                                <span style="font-size:26px; font-weight:900; color:#6366f1; letter-spacing:-0.02em;" x-text="'S/ ' + getTotal().toFixed(2)"></span>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div style="padding:18px 28px; display:flex; gap:12px; flex-shrink:0; border-top:1px solid #e2e8f0;">
                            <button @click="showConfirm = false" :disabled="processing" class="pos-dialog-btn-cancel">
                                Cancelar
                            </button>
                            <button @click="processSale()" :disabled="processing" class="pos-dialog-btn-confirm"
                                :style="processing ? 'opacity:0.7;cursor:wait;' : ''">
                                <template x-if="!processing">
                                    <span style="display:flex; align-items:center; gap:8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Confirmar Venta
                                    </span>
                                </template>
                                <template x-if="processing">
                                    <span style="display:flex; align-items:center; gap:8px;">
                                        <svg style="width:16px;height:16px;animation:spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Procesando...
                                    </span>
                                </template>
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Estado: Venta exitosa -->
                <template x-if="saleSuccess">
                    <div style="padding:48px 36px; text-align:center;">
                        <div style="width:64px; height:64px; background:#dcfce7; margin:0 auto 20px; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:30px;height:30px;color:#16a34a;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <h3 style="font-size:20px; font-weight:900; color:#1e293b; margin-bottom:6px;">Venta Registrada</h3>
                        <p style="font-size:12px; color:#94a3b8; margin-bottom:20px;">Comprobante generado exitosamente</p>
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px 20px; margin-bottom:12px;">
                            <div style="font-size:9px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:6px;">N. Comprobante</div>
                            <div style="font-size:15px; font-weight:800; color:#6366f1;" x-text="saleComprobante"></div>
                        </div>
                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:16px 20px; margin-bottom:28px; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:12px; font-weight:700; color:#15803d; text-transform:uppercase;">Total cobrado</span>
                            <span style="font-size:22px; font-weight:900; color:#15803d;" x-text="'S/ ' + saleTotal"></span>
                        </div>
                        <button @click="closeSuccessDialog()" class="pos-dialog-btn-confirm" style="width:100%;">
                            <span style="display:flex; align-items:center; justify-content:center; gap:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Nueva Venta
                            </span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- Notificación toast -->
    <div x-show="notification.show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="position:fixed; bottom:20px; left:50%; transform:translateX(-50%); z-index:100; padding:8px 16px; background:#1e293b; color:#fff; font-size:11px; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,0.15); display:flex; align-items:center; gap:6px;">
        <svg xmlns="http://www.w3.org/2000/svg" style="width:13px;height:13px;color:#34d399;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
        <span x-text="notification.message"></span>
    </div>
</div>
@endsection

@push('scripts')
<script>
function posSystem() {
    return {
        search: '',
        productos: @json($productos),
        cart: [],
        cliente_id: '',
        metodo_pago: 'Efectivo',
        processing: false,
        showConfirm: false,
        saleSuccess: false,
        saleComprobante: '',
        saleTotal: '0.00',
        notification: { show: false, message: '' },

        get filteredProducts() {
            if (!this.search) return this.productos;
            const s = this.search.toLowerCase();
            return this.productos.filter(p =>
                p.nombre.toLowerCase().includes(s) ||
                p.codigo.toLowerCase().includes(s)
            );
        },

        addToCart(product) {
            if (product.stock <= 0) return;
            const existing = this.cart.find(item => item.id_producto === product.id_producto);
            if (existing) {
                if (existing.qty < product.stock) {
                    existing.qty++;
                    this.showNotification(product.nombre + ' (' + existing.qty + ')');
                } else {
                    this.showNotification('Stock insuficiente');
                }
            } else {
                this.cart.push({
                    id_producto: product.id_producto,
                    nombre: product.nombre,
                    codigo: product.codigo,
                    precio_venta: product.precio_venta,
                    qty: 1,
                    stock: product.stock
                });
                this.showNotification(product.nombre + ' agregado');
            }
        },

        removeFromCart(index) { this.cart.splice(index, 1); },

        clearCart() {
            this.cart = [];
            this.showNotification('Carrito limpiado');
        },

        updateQty(index, amount) {
            const item = this.cart[index];
            const newQty = item.qty + amount;
            if (newQty <= 0) { this.removeFromCart(index); }
            else if (newQty <= item.stock) { item.qty = newQty; }
            else { this.showNotification('Stock insuficiente'); }
        },

        getTotal() { return this.cart.reduce((s, i) => s + (i.precio_venta * i.qty), 0); },
        getTotalItems() { return this.cart.reduce((s, i) => s + i.qty, 0); },

        getClienteName() {
            if (!this.cliente_id) return 'Mostrador (Sin cliente)';
            const select = document.querySelector('select[x-model="cliente_id"]');
            return select ? select.options[select.selectedIndex].text : 'Cliente';
        },

        closeSuccessDialog() {
            this.showConfirm = false;
            this.saleSuccess = false;
            this.saleComprobante = '';
            this.saleTotal = '0.00';
        },

        showNotification(message) {
            this.notification.show = true;
            this.notification.message = message;
            setTimeout(() => { this.notification.show = false; }, 1500);
        },

        async processSale() {
            if (this.cart.length === 0) return;
            this.processing = true;

            const payload = {
                cliente_id: this.cliente_id,
                metodo_pago: this.metodo_pago,
                items: this.cart.map(item => ({ producto_id: item.id_producto, cantidad: item.qty })),
                _token: '{{ csrf_token() }}'
            };

            try {
                const response = await fetch('{{ route('ventas.store') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const result = await response.json();
                if (result.success) {
                    this.saleTotal = this.getTotal().toFixed(2);
                    this.saleComprobante = result.comprobante || 'Venta registrada';
                    // Restar stock de los productos vendidos
                    this.cart.forEach(item => {
                        const prod = this.productos.find(p => p.id_producto === item.id_producto);
                        if (prod) prod.stock = Math.max(0, prod.stock - item.qty);
                    });
                    this.cart = [];
                    this.cliente_id = '';
                    this.metodo_pago = 'Efectivo';
                    this.processing = false;
                    this.saleSuccess = true;
                } else {
                    this.showNotification(result.message || 'Error al procesar');
                    this.processing = false;
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error de conexión');
                this.processing = false;
            }
        }
    }
}
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }

/* Scrollbar delgado */
.pos-scrollbar::-webkit-scrollbar { width: 4px; }
.pos-scrollbar::-webkit-scrollbar-track { background: transparent; }
.pos-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
.pos-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

/* Grid: mínimo 6 columnas con auto-fill */
.pos-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 6px;
}
@media (min-width: 1200px) {
    .pos-grid { grid-template-columns: repeat(7, 1fr); }
}
@media (min-width: 1400px) {
    .pos-grid { grid-template-columns: repeat(8, 1fr); }
}
@media (min-width: 1700px) {
    .pos-grid { grid-template-columns: repeat(9, 1fr); }
}

/* Tarjeta producto */
.pos-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.pos-card:hover {
    border-color: #6366f1;
    box-shadow: 0 2px 10px rgba(99, 102, 241, 0.1);
}
.pos-card:active {
    transform: scale(0.97);
}

/* Imagen producto */
.pos-card-img {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    background: #f1f5f9;
    overflow: hidden;
}

/* Badge stock */
.pos-badge {
    position: absolute;
    top: 3px;
    right: 3px;
    padding: 1px 4px;
    font-size: 8px;
    font-weight: 700;
    line-height: 1.5;
    background: rgba(255,255,255,0.9);
    color: #64748b;
}

/* Info tarjeta */
.pos-card-info {
    padding: 4px 6px 6px;
}
.pos-card-name {
    font-size: 9px;
    font-weight: 600;
    color: #334155;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
}
.pos-card-price {
    font-size: 11px;
    font-weight: 800;
    color: #6366f1;
    line-height: 1.3;
}

/* Items del carrito */
.pos-cart-item {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.1s;
}
.pos-cart-item:hover {
    background: #f8fafc;
}

/* Botón +/- cantidad */
.pos-qty-btn {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border: 1px solid #e2e8f0;
    cursor: pointer;
    transition: background 0.15s;
}
.pos-qty-btn:hover {
    background: #f1f5f9;
}

/* Botón eliminar */
.pos-remove-btn {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    color: #cbd5e1;
    cursor: pointer;
    flex-shrink: 0;
    transition: color 0.15s;
}
.pos-remove-btn:hover {
    color: #ef4444;
}

/* Botones método de pago */
.pos-pago-btn {
    flex: 1;
    padding: 10px 0;
    background: #fff;
    border: 2px solid #e2e8f0;
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    transition: all 0.15s;
    border-radius: 6px;
}
.pos-pago-btn:hover {
    border-color: #c7d2fe;
    background: #fafafe;
}
.pos-pago-btn.pos-pago-active {
    background: #eef2ff;
    border-color: #6366f1;
    color: #4f46e5;
    font-weight: 700;
}

/* Botón cobrar */
.pos-btn-cobrar {
    width: 100%;
    padding: 12px 0;
    background: #6366f1;
    color: #fff;
    border: none;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    border-radius: 6px;
}
.pos-btn-cobrar:hover:not(:disabled) {
    background: #4f46e5;
}

/* Dialog */
.pos-dialog {
    position: relative;
    background: #fff;
    width: 460px;
    max-height: 80vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 24px 64px rgba(0,0,0,0.2), 0 0 0 1px rgba(0,0,0,0.05);
    overflow: hidden;
    border-radius: 12px;
}
.pos-dialog-close {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    border: none;
    color: #64748b;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.15s;
}
.pos-dialog-close:hover {
    background: #fee2e2;
    color: #ef4444;
}
.pos-dialog-btn-cancel {
    flex: 1;
    padding: 12px 0;
    background: #fff;
    border: 1px solid #e2e8f0;
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    transition: all 0.15s;
    border-radius: 8px;
}
.pos-dialog-btn-cancel:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
}
.pos-dialog-btn-confirm {
    flex: 2;
    padding: 12px 0;
    background: #6366f1;
    border: none;
    font-size: 12px;
    font-weight: 800;
    color: #fff;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    border-radius: 8px;
}
.pos-dialog-btn-confirm:hover {
    background: #4f46e5;
}
</style>
@endpush
