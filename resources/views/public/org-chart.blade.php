@extends('layouts.layout')

@section('title', 'Organizational Chart - GAD FGPS')

@section('content')
<div style="margin-top: 65px; padding: 3rem 1rem; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <!-- Header Banner -->
        <div style="background-color: #1F3864; color: white; padding: 2rem; text-align: center; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h1 style="font-size: 2rem; font-weight: bold; margin: 0;">
                <i class="fas fa-sitemap"></i> GAD FOCAL POINT SYSTEM (GFPS)
            </h1>
            <p style="margin: 0.5rem 0 0; font-size: 1.1rem;">Office Order No. 10, Series 2015</p>
        </div>

        <!-- AI Summary Banner -->
        @if($summary)
            <div style="background-color: #E3F2FD; border-left: 4px solid #2E75B6; padding: 1.5rem; margin-bottom: 2rem; border-radius: 4px;">
                <p style="margin: 0; color: #1565C0; font-size: 1rem; line-height: 1.6;">
                    {{ $summary }}
                </p>
            </div>
        @endif

        <!-- Statistics -->
        <div class="columns is-centered mb-5">
            <div class="column is-one-third">
                <div style="background: white; padding: 1.5rem; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <p style="font-size: 2rem; font-weight: bold; color: #1F3864; margin: 0;">
                        {{ $members->count() }}
                    </p>
                    <p style="color: #666; margin-top: 0.5rem;">Total Positions</p>
                </div>
            </div>
            <div class="column is-one-third">
                <div style="background: white; padding: 1.5rem; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <p style="font-size: 2rem; font-weight: bold; color: #2E75B6; margin: 0;">
                        {{ $members->where('is_vacant', false)->count() }}
                    </p>
                    <p style="color: #666; margin-top: 0.5rem;">Filled Positions</p>
                </div>
            </div>
            <div class="column is-one-third">
                <div style="background: white; padding: 1.5rem; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <p style="font-size: 2rem; font-weight: bold; color: #F57C00; margin: 0;">
                        {{ $members->where('is_vacant', true)->count() }}
                    </p>
                    <p style="color: #666; margin-top: 0.5rem;">Vacant Positions</p>
                </div>
            </div>
        </div>

        <!-- Organizational Chart by Section -->
        @foreach($grouped as $section => $members)
            <div style="background: white; padding: 2rem; margin-bottom: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <!-- Section Header -->
                <div style="background-color: #2E75B6; color: white; padding: 1rem; margin: -2rem -2rem 1.5rem -2rem; border-radius: 8px 8px 0 0; text-align: center;">
                    <h2 style="font-size: 1.3rem; font-weight: bold; margin: 0;">
                        {{ $section }}
                    </h2>
                </div>

                <!-- Members Grid/Flex Container -->
                <div class="{{ $section === 'Deans / Campus Level' ? 'deans-row' : 'org-section' }}">
                    @foreach($members as $member)
                        <div class="gfps-card {{ $member->is_vacant ? 'vacant' : '' }}" 
                             style="
                                background-color: {{ $member->is_vacant ? '#F5F5F5' : '#1F3864' }};
                                color: {{ $member->is_vacant ? '#999' : 'white' }};
                                border: {{ $member->is_vacant ? '2px dashed #DDD' : '2px solid #1F3864' }};
                                padding: 1.5rem;
                                border-radius: 8px;
                                text-align: center;
                                transition: all 0.3s ease;
                                box-shadow: {{ $member->is_vacant ? '0 2px 4px rgba(0,0,0,0.05)' : '0 4px 8px rgba(0,0,0,0.2)' }};
                                cursor: default;
                             "
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='{{ $member->is_vacant ? '0 4px 8px rgba(0,0,0,0.1)' : '0 6px 12px rgba(0,0,0,0.3)' }}';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='{{ $member->is_vacant ? '0 2px 4px rgba(0,0,0,0.05)' : '0 4px 8px rgba(0,0,0,0.2)' }}';">
                            
                            <div style="font-size: 0.85rem; font-weight: bold; margin-bottom: 0.5rem; opacity: 0.9;">
                                {{ $member->gfps_role }}
                            </div>
                            
                            <div style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.8rem;">
                                {{ $member->gfps_position }}
                            </div>

                            <hr style="border: none; border-top: {{ $member->is_vacant ? '1px dashed #DDD' : '1px solid rgba(255,255,255,0.3)' }}; margin: 0.8rem 0;">
                            
                            <div style="font-size: 1rem; font-weight: bold; margin-bottom: 0.3rem; font-style: {{ $member->is_vacant ? 'italic' : 'normal' }};">
                                {{ $member->display_name }}
                            </div>

                            @if($member->designation)
                                <div style="font-size: 0.85rem; margin-top: 0.5rem; opacity: {{ $member->is_vacant ? '0.7' : '0.9' }};">
                                    {{ $member->designation }}
                                </div>
                            @endif

                            @if($member->remarks && $member->remarks !== '')
                                <div style="font-size: 0.8rem; margin-top: 1rem; padding-top: 0.8rem; border-top: {{ $member->is_vacant ? '1px dashed #DDD' : '1px solid rgba(255,255,255,0.2)' }}; opacity: 0.85; font-style: italic;">
                                    {{ $member->remarks }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Legend -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin-top: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="font-weight: bold; margin-bottom: 1rem; color: #1F3864;">
                <i class="fas fa-info-circle"></i> Legend
            </h3>
            <div class="columns">
                <div class="column is-half">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 50px; height: 50px; background-color: #1F3864; border-radius: 4px;"></div>
                        <div>
                            <p style="margin: 0; font-weight: bold;">Filled Position</p>
                            <p style="margin: 0; color: #666; font-size: 0.9rem;">Officer/Staff assigned</p>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background-color: #F5F5F5; border: 2px dashed #DDD; border-radius: 4px;"></div>
                        <div>
                            <p style="margin: 0; font-weight: bold;">Vacant Position</p>
                            <p style="margin: 0; color: #666; font-size: 0.9rem;">Awaiting assignment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .gfps-card {
        position: relative;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Standard grid for sections with reasonable number of items */
    .org-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    /* Special wrapping grid for Deans section (12 cards) */
    .deans-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
        padding: 0.5rem 0;
    }

    .deans-row .gfps-card {
        width: 200px;
        min-height: 180px;
        flex-shrink: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .deans-row .gfps-card {
            width: 180px;
            min-height: 160px;
        }
    }

    @media (max-width: 768px) {
        .gfps-card {
            min-height: 150px;
            padding: 1rem !important;
        }

        .deans-row .gfps-card {
            width: calc(50% - 0.75rem);
            min-height: 140px;
        }
    }

    @media (max-width: 640px) {
        .org-section {
            grid-template-columns: 1fr !important;
        }

        .deans-row .gfps-card {
            width: 100% !important;
            min-height: auto;
        }

        .deans-row {
            justify-content: stretch;
            gap: 1rem;
        }
    }
</style>
@endsection
