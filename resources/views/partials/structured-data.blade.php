<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "name": "{{ __(config('app.name')) }}",
      "url": "{{ config('app.url') }}",
      "logo": "{{ asset('img/logo.png') }}",
      "description": "{{ __(config('rb.SITE_DESCRIPTION')) }}",
      "foundingDate": "2017",
      "contactPoint": {
        "@type": "ContactPoint",
        "email": "info@nyasacv.com",
        "contactType": "Customer Service"
      },
      "sameAs": []
    },
    {
      "@type": "WebSite",
      "name": "{{ __(config('app.name')) }}",
      "url": "{{ config('app.url') }}",
      "description": "{{ __(config('rb.SITE_DESCRIPTION')) }}",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ config('app.url') }}/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    },
    {
      "@type": "SoftwareApplication",
      "name": "{{ __(config('app.name')) }} Resume Builder",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "Web Browser",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "{{ config('rb.CURRENCY_CODE') }}",
        "description": "Free CV builder with premium options"
      },
      "description": "Professional resume builder with drag and drop functionality. Create stunning CVs in minutes with customizable templates.",
      "screenshot": "{{ asset('img/logo.png') }}",
      "featureList": [
        "Drag and drop resume builder",
        "Multiple professional templates",
        "PDF export",
        "Customizable layouts",
        "ATS-friendly formats"
      ],
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "ratingCount": "1250",
        "bestRating": "5",
        "worstRating": "1"
      }
    },
    {
      "@type": "Service",
      "serviceType": "Resume Writing and CV Building Service",
      "provider": {
        "@type": "Organization",
        "name": "{{ __(config('app.name')) }}"
      },
      "areaServed": {
        "@type": "Place",
        "name": "Worldwide"
      },
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Resume Building Services",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Professional Resume Templates",
              "description": "Access to multiple professional resume templates"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "CV Builder Tool",
              "description": "Drag and drop resume builder with real-time preview"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "PDF Export",
              "description": "Export your resume as a professional PDF document"
            }
          }
        ]
      }
    }
  ]
}
</script>
